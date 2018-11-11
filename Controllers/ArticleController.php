<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Transformers\ArticleBlockTransformer;
use App\Http\Transformers\ArticleTransformer;
use App\Models\Article;
use App\Models\ArticleBlock;
use App\Models\ArticleBlockType;
use App\Models\File;
use App\Models\Game;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use View;
use Carbon\Carbon;

class ArticleController extends Controller
{

    public function __construct()
    {
        //
    }
    
    /**
     * @return mixed
     */
    public function create()
    {
        $article = Article::create([
                'start_date' => Carbon::now(),
                'created_by' => Auth::user()->id
            ]
        );
        $article->save();
        return self::edit($article->id);
    }
    
    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $article = Article::with(
            'templateBlocks',
            'templateBlocks.articleBlockType',
            'templateBlocks.file',
            'header',
            'card',
            'author',
            'author.theme',
            'game',
            'game.cover',
            'topics'
        )->where('id', $id)->first();

        $transform = (new ArticleTransformer())->transform($article);

        return view('admin.article.edit')->with([
            'auth' => Auth::user(),
            'article' => $transform,
            'games' => Game::options(),
            'topics' => Topic::options(),
            'form_type' => 'edit'
        ]);
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        try {
            $data = $request->form;
            $auth = Auth::user();
            $article = Article::find($data['id']);

            $start_date = null;
            $expiry_date = null;

            if($data['start_date']) {
                $start_date = Carbon::parse($data['start_date']);
            }

            if($data['expiry_date']) {
                if(!is_null($data['expiry_date'])){
                    $expiry_date = Carbon::parse($data['expiry_date']);
                }
            }

            $article->update([
                'title' => strip_tags($data['title']),
                'card_title' => strip_tags($data['card_title']),
                'card_description' => strip_tags($data['card_description']),
                'card_title_manual' => $data['card_title_manual'] == 'true' ? 1 : 0,
                'admin_notes' => strip_tags($data['admin_notes']),
                'slug' => strip_tags($data['slug']),
                'slug_manual' => $data['slug_manual'] == 'true' ? 1 : 0,
                'start_date' => $start_date,
                'expiry_date' => $expiry_date,
                'game_id' => (isset($data['game_id'])) ? $data['game_id'] : null,
                'updated_by' => $auth->id
            ]);

            if(isset($data['topics'])) {
                $article->topics()->sync($data['topics']);
            }

            $article->save();
            
            // Save article blocks (if any)
            $this->_process_article_blocks($request->blocks);
    
            return response()->json('Updated Successfully', 200);
        } catch (Exception $e) {
            return response()->json('There was an error', 412);
    
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function _process_article_blocks($article_blocks = array())
    {
        if(count($article_blocks) > 0) {
            foreach ($article_blocks as $article_block) {
                switch($article_block['article_block_type_id']) {
                    case '1': // heading
                    case '2': // subheading
                    case '3': // text-block
                    case '4': // image
                    case '5': // video
                    case '6': // link
                    case '7': // quote
                        //Find Associated Block
                        $block = ArticleBlock::find($article_block['id']);
                        if($block) {
                            $block->update($article_block);
                            $block->save();
                        }
                        break;
                    case 'image-gallery':
                        //ToDo: Saving Gallery
                    break;
                }
            }
        }
        return;
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleMainFeatured(Request $request)
    {
        if(Auth::user()->isAdmin()) {

            //First check if there is an existing article set to main feature already
            $existing_main_featured = Article::where('main_featured', 1)->first();

            //If there is already a main_featured article and it is NOT the current article, error
            if(count($existing_main_featured) > 0 && $existing_main_featured->id != $request->article_id) {
                //If Forced is set to False, respond with override again
                if($request->forced == 'false') {
                    $response = [
                        'existing_id' => $existing_main_featured->id,
                        'existing_title' => $existing_main_featured->title
                    ];
                    return response()->json($response, 403);
                }
                //Otherwise set the current Main Featured back to not main_featured.
                else {
                    $existing_main_featured->main_featured = 0;
                    $existing_main_featured->save();
                }
            }

            //Grab the Article, Update the FEATURED with checked and then save.
            $article = Article::find($request->article_id);
            $article->main_featured = $request->checked;
            $article->save();

            return response()->json('Updated', 200);
        }
        
        return response()->json('Unauthorised', 401);
    
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageUpload(Request $request) {

        //Set Data from request
        $croppedImage = $request->croppedImage;
        $originalName = $request->originalName;
        $entityId = $request->entityId;
        $entityType = $request->entityType;
        $remotePath = $request->remotePath;

        //Store the file on the Cloud Server
        $remote_upload = Storage::disk('spaces')->putFile($remotePath, $croppedImage, 'public');

        //If successfully uploaded to the Cloud Server
        if($remote_upload) {

            //Get the random file name from the Cloud after upload
            $split = preg_split("/[\\/]+/", $remote_upload);
            $random_name = end($split);

            //Add File to the local Database
            $file = File::create([
                'file_name' => $originalName,
                'random_name' => $random_name,
                'path' => $remotePath,
                'created_by' => Auth::id()
            ]);

            //Entity Specific Actions

            if($entityType == 'articleBlock') {

                $block = ArticleBlock::find($entityId);

                //Update the Block File ID
                $block->file_id = $file->id;
                $block->save();

            }
            elseif($entityType == 'articleHeader') {

                $article = Article::find($entityId);

                //Update the Article Header Image ID
                $article->header_image = $file->id;
                $article->save();

            }
            elseif($entityType == 'articleCard') {

                $article = Article::find($entityId);

                //Update the Article Header Image ID
                $article->card_image = $file->id;
                $article->save();

            }
            elseif($entityType == 'gameCover') {

                $game = Game::find($entityId);

                //Update the Game Cover Image ID
                $game->cover_image = $file->id;
                $game->save();

            }

            $response = [
                'message' => $originalName . ' was uploaded successfully.',
                'new_path' => $file->getCloudPath(),
                'file_id' => $file->id,
            ];

            return response()->json($response, 200);
        }

        return response()->json('There was an unknown error', 500);

    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function resequence(Request $request) {
        foreach ($request->get('blocks', []) as $index => $block) {
            ArticleBlock::query()->where('id', $block['id'])->update(['sequence' => $index]);
        }

        $response = [
            'msg' => 'Resequence Complete'
        ];

        return response()->json($response, 200);
    }
}
