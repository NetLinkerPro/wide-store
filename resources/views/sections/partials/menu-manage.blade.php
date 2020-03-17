<div class="filter__rlink">
    <context-menu button-class="filter__slink" right>
        <template slot="toggler">
            <span>{{ __('wide-store::general.shops') }}</span>
        </template>
        @include('wide-store::sections.partials.shop-menu-manage')
    </context-menu>
</div>
<div class="filter__rlink">
    <context-menu button-class="filter__slink" right>
        <template slot="toggler">
            <span>{{ __('wide-store::general.sources') }}</span>
        </template>
        @include('wide-store::sections.partials.source-menu-manage')
    </context-menu>
</div>
<div class="filter__rlink">
    <context-menu button-class="filter__slink" right>
        <template slot="toggler">
            <span>{{ __('wide-store::settings.settings') }}</span>
        </template>
        @include('wide-store::sections.partials.setting-menu-manage')
    </context-menu>
</div>