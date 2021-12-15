
        <div class="p-2 text-center">
            <button class="btn btn-icon btn-primary" type="button">
                <a href="{{ route('tcb-amazon-sync.amazon.asinsetup', ['item_id' => $inventory_item->id]) }}" class="text-white">
                    <span class="btn-inner--icon"><i class="fab fa-amazon"></i></span>
                    <span class="btn-inner--text">Amazon</span>
                </a>
            </button>
            <!--
            <button class="btn btn-icon btn-primary" type="button">
                <a href="" class="text-white">
                    <span class="btn-inner--icon"><i class="fab fa-ebay"></i></span>
                    <span class="btn-inner--text">eBay</span>
                </a>
            </button>
            <button class="btn btn-icon btn-primary" type="button">
                <a href="" class="text-white">
                    <span class="btn-inner--icon"><i class="fab fa-magento"></i></span>
                    <span class="btn-inner--text">Magento Shop</span>
                </a>
            </button>
            -->
        </div>