<div class="block-header">
    <div class="row clearfix">
        <div class="col-md-6 col-sm-12">
            <h1>{{ $breadcrumb['heading'] }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Helium</a></li>
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['page'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['current_page'] }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
