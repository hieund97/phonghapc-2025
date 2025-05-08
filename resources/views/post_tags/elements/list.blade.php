<div class="col-md">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('List of post tags') }}</h3>

            <div class="card-tools">
                {{-- @include('partials.cards.search') --}}
                <a href="{{ route('post_tags.index') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i>
                    {{ __('Create') }}
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="just-padding">
                <div class="list-group list-group-root well">
                    @php
                            foreach ($postTags as $postTag) {
      
                                echo '<div href="#item-'.$postTag->id.'" class="postTag-list list-group-item" data-toggle="collapse">';
                                echo '<i class="fa fa-chevron-right"></i>'.$postTag->title;
                                echo '<span class="float-right">';
                                echo '<a class="prevent-expand btn btn-warning btn-sm" onclick="window.open(\''.route('fe.post.tag',['slug'=>$postTag->slug,'id'=>$postTag->id]).'\', \'_blank\');" href="'.route('fe.post.tag',['slug'=>$postTag->slug,'id'=>$postTag->id]).'">Xem chi tiết</a>'; 
                                if (request()->user()->can('post_tags.update')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-warning btn-sm" onclick="$.pjax({url: \''.route('post_tags.index', ['id' => $postTag->id]).'\', container: \'#pjax-container\'});">'.__('Edit').'</span>';
                                }

                                if (request()->user()->can('post_tags.destroy')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-danger btn-sm" onclick="deleteResource(\''.route('post_tags.destroy', ['post_tag' => $postTag->id]).'\', \''.route('post_tags.index').'\')">'.__('Delete').'</span>';
                                }

                                echo '</span>';
                                echo '</div>';

                            }                        
                    @endphp
                </div>
            </div>
        </div>

        @if ($postTags->hasPages())
            <div class="card-footer clearfix pb-0">
                <div class="pagination-sm m-0 float-right">
                    {{ $postTags->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>