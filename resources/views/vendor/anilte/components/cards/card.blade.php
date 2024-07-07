<div class="card card-primary {{ $cardClass }}">
    @if (isset($header))
        <div class="card-header {{ $headerClass }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="nav nav-tabs mt-1" id="custom-tabs-one-tab " role="tablist">
                    {{ $header }}
                </div>
                <div class="card-tools">
                    @isset($minimize)
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    @endisset
                    @isset($maximize)
                        <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    @endisset
                    @isset($close)
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    @endisset
                </div>
            </div>
        </div>
    @endif
    @if (isset($body))
        <div class="card-body {{ $bodyClass }}">
            {{ $body }}
        </div>
    @endif
    @if (isset($footer))
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>
