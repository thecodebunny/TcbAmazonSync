<li class="nav-item dropdown">
    <a class="nav-link amazon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="TheCodeBunny Amazon Sync" role="button" aria-haspopup="true"
        aria-expanded="false">
        <span>
            <i class="fab fa-amazon"></i>
        </span>
        @if ($unshippedOrders)
            <span class="badge badge-md badge-circle badge-reminder badge-default">
                <i class="fas fa-info"></i>
            </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0 overflow-hidden">
        <div class="list-group list-group-flush">
            <a href="https://go.zoomyo.com/1/common/notifications#new-apps"
                class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-rocket"></i>
                    </div>
                    <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-sm">You have {{ count($unshippedOrders) }} Unshipped Orders</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</li>