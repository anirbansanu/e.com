<!-- resources/views/vendor/anilte/vertical-tab-pills.blade.php -->

@props(['tabs','userName','userRole'])

<div class="row">
    <div class="col-3 ">
        <div class="card card-widget widget-user-2 ">
            <div class="widget-user-header bg-gradient-blue mb-3">
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="https://adminlte.io/themes/v3/dist/img/user7-128x128.jpg" alt="User Avatar">
                </div>

                <h3 class="widget-user-username">{{$userName}}</h3>
                <h5 class="widget-user-desc">{{$userRole}}</h5>
            </div>

            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                @foreach($tabs as $key => $tab)
                    <a class="nav-link @if($loop->first) active @endif" id="v-pills-{{ $key }}-tab" data-toggle="pill" href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected="@if($loop->first) true @else false @endif">{{ $tab }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent">
            @foreach($tabs as $key => $tab)
                <div class="tab-pane fade @if($loop->first) show active @endif" id="v-pills-{{ $key }}" role="tabpanel" aria-labelledby="v-pills-{{ $key }}-tab">
                    @isset(${$key})
                        {{ ${$key} }}
                    @endisset
                </div>
            @endforeach
        </div>
    </div>
</div>
