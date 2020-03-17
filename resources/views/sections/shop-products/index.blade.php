@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shop-products.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::shop-products.meta_description'))

@push('head')
    @include('wide-store::integration.favicons')
    @include('wide-store::integration.ga')
@endpush

@section('create_button')
    <button class="frame__header-add" @click="AWES.emit('modal::form:open')"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="filter">
        <div class="grid grid-align-center grid-justify-between grid-justify-center--mlg">
            <div class="cell-inline cell-1-1--mlg">

            </div>
            <div class="cell-inline">
                @include('wide-store::sections.partials.menu-manage')
            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'shop_products_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shop_products.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shop-products.product_list') }}</h3>
        </template>
        <tb-column name="no_field_shop_uuid" label="{{__('wide-store::shop-products.shop') }}">
            <template slot-scope="col">
                @{{ col.data.shop.name }}
            </template>
        </tb-column>
        <tb-column name="no_field_category_uuid" label="{{__('wide-store::shop-categories.category') }}">
            <template slot-scope="col">
                @{{ col.data.category.name }}
            </template>
        </tb-column>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="identifier" label="{{__('wide-store::general.identifier') }}">
            <template slot-scope="col">
                @{{ col.data.identifier }}
            </template>
        </tb-column>
        <tb-column name="name" label="{{__('wide-store::general.name') }}">
            <template slot-scope="col">
                @{{ col.data.name }}
            </template>
        </tb-column>
        <tb-column name="price" label="{{__('wide-store::shop-products.price_netto') }}">
            <template slot-scope="col">
                @{{ col.data.price }}
            </template>
        </tb-column>
        <tb-column name="tax" label="{{__('wide-store::general.tax') }}">
            <template slot-scope="col">
                @{{ col.data.tax }}
            </template>
        </tb-column>
        <tb-column name="url" label="{{__('wide-store::general.url') }}">
            <template slot-scope="col">
                @{{ col.data.url }}
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editShopProduct', data: d.data}); AWES.emit('modal::edit-shop-product:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteShopProduct', data: d.data}); AWES.emit('modal::delete-shop-product:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop product--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shop-products.addition_product') }}">
        <form-builder name="add-shop-product" url="{{ route('wide-store.shop_products.store') }}" @sended="AWES.emit('content::shop_products_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-shop-product']">

                <fb-select name="shop_uuid" label="{{ __('wide-store::shop-products.shop') }}"
                           url="{{route('wide-store.shops.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="category_uuid" label="{{ __('wide-store::shop-categories.category') }}"
                           url="{{route('wide-store.shop_categories.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-input name="price" label="{{ __('wide-store::shop-products.price_netto') }}"></fb-input>
                <fb-input name="tax" label="{{ __('wide-store::general.tax') }}"></fb-input>
                <fb-input name="url" label="{{ __('wide-store::general.url') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit shop product--}}
    <modal-window name="edit-shop-product" class="modal_formbuilder" title="{{ __('wide-store::shop-products.edition_product') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shop_products.index') }}/{id}" store-data="editShopProduct" @sended="AWES.emit('content::shop_products_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="shop_uuid"></fb-input>
            <fb-input type="hidden" name="category_uuid"></fb-input>
            <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-input name="price" label="{{ __('wide-store::shop-products.price_netto') }}"></fb-input>
            <fb-input name="tax" label="{{ __('wide-store::general.tax') }}"></fb-input>
            <fb-input name="url" label="{{ __('wide-store::general.url') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete shop product--}}
    <modal-window name="delete-shop-product" class="modal_formbuilder" title="{{ __('wide-store::shop-products.are_you_sure_delete_product') }}">
        <form-builder name="delete-shop-product" method="DELETE" url="{{ route('wide-store.shop_products.index') }}/{id}" store-data="deleteShopProduct" @sended="AWES.emit('content::shop_products_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop-product']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
