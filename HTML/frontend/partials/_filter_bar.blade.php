<div class="row filter-row">
    <div class="col-12">
        <form>
            <div class="filter-bar">
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::select('filter_platform', [0 => 'All', 1 => 'Playstation', 2 => 'Xbox', 3 => 'Nintendo', 4 => 'PC'], null, ['id' => 'filter_platform', 'class' => 'filter-dropdown', 'placeholder' => 'Select a Platform...', 'multiple']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('filter_topic', [0 => 'All', 1 => 'Articles', 2 => 'Screenshots', 3 => 'Trailers'], null, ['id' => 'filter_topic', 'class' => 'filter-dropdown', 'placeholder' => 'Select a Topic...', 'multiple']) !!}
                    </div>
                </div>
            </div>
            <div class="filter-btn">
                <div class="btn-box">
                    <jump-button
                            btn_url="#"
                            btn_icon="{{ url('images/icons/icon-reset.svg') }}"
                    ></jump-button>
                </div>
            </div>
        </form>
    </div>
</div>