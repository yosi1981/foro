<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.dashboard.recent_updates') }}</h3>
    </div>
    <div class="box-body">
        <p>
           {{ trans('admin.dashboard.recent_forum_stats') }}
        </p>
        <ul class="list-group list-group-unbordered">
            @foreach ($most_recent_stats as $most_recent_stat)
                <li class="list-group-item">
                    <span class="text-muted">
                        {{ $most_recent_stat['name'] }}
                    </span>
                    <br>
                    <a href="{{ $most_recent_stat['url'] }}" class="bold">
                        {{ $most_recent_stat['value'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>