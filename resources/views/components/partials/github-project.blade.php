@if($project->html_url)
    <a href="{{$project->html_url}}" target="_blank">
        @endif


        <div class="card hover:bg-gradient-to-b hover:from-primary-500 hover:to-primary-50">
            <div class="card-header">
                <div class="flex flex-row gap-1">
                    <h2>{{$project->name}}</h2>
                </div>
                @if($project->language)
                    <small class="repo-language">{{$project->language}}</small>
                @endif
            </div>

            @if($project->description)
                <div class="card-body">
                    <p>{{$project->description}}</p>
                </div>
            @endif

            <div class="card-footer">
                @if($project->repo_pushed_at)
                    <small>Last Updated on {{$project->repo_pushed_at->format('d/m/Y')}}</small>
                @endif

                @if($project->repo_created_at)
                    <small>Created on {{$project->repo_created_at->format('d/m/Y')}}</small>
                @endif
            </div>
        </div>
        @if($project->html_url)
    </a>
@endif
