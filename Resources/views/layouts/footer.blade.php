@stack('footer_start')
    <footer class="footer">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="text-sm float-left text-muted footer-texts">
                    <a href="{{ trans('tcb-amazon-sync::general.tcb') }}" target="_blank" class="text-muted">{{ trans('tcb-amazon-sync::general.powered') }} {{ trans('tcb-amazon-sync::general.tcb') }}</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="text-sm float-right text-muted footer-texts">
                    {{ trans('footer.version') }} {{ version('short') }}
                </div>
            </div>
        </div>
    </footer>
@stack('footer_end')
