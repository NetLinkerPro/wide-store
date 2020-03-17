@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shop-stocks.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::shop-stocks.meta_description'))

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
            'name' => 'shop_stocks_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shop_stocks.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shop-stocks.stock_list') }}</h3>
        </template>
        <tb-column name="no_field_shop_uuid" label="{{__('wide-store::shop-stocks.shop') }}">
            <template slot-scope="col">
                @{{ col.data.shop.name }}
            </template>
        </tb-column>
        <tb-column name="no_field_product_uuid" label="{{__('wide-store::general.product') }}">
            <template slot-scope="col">
                @{{ col.data.product.name }}
            </template>
        </tb-column>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="stock" label="{{__('wide-store::shop-stocks.stock') }}">
            <template slot-scope="col">
                @{{ col.data.stock }}
            </template>
        </tb-column>
        <tb-column name="availability" label="{{__('wide-store::shop-stocks.availability') }}">
            <template slot-scope="col">
                @{{ col.data.availability }}
            </template>
        </tb-column>
        <tb-column name="department" label="{{__('wide-store::shop-stocks.department') }}">
            <template slot-scope="col">
                @{{ col.data.department }}
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editStock', data: d.data}); AWES.emit('modal::edit-shop-stock:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteStock', data: d.data}); AWES.emit('modal::delete-shop-stock:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop stock--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shop-stocks.addition_stock') }}">
        <form-builder name="add-shop-stock" url="{{ route('wide-store.shop_stocks.store') }}" @sended="AWES.emit('content::shop_stocks_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-shop-stock']">

                <fb-select name="shop_uuid" label="{{ __('wide-store::shop-stocks.shop') }}"
                           url="{{route('wide-store.shops.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.shop_products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input type="number" name="stock" label="{{ __('wide-store::shop-stocks.stock') }}"></fb-input>
                <fb-input name="availability" label="{{ __('wide-store::shop-stocks.availability') }}"></fb-input>
                <fb-input name="department" label="{{ __('wide-store::shop-stocks.department') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit shop stock--}}
    <modal-window name="edit-shop-stock" class="modal_formbuilder" title="{{ __('wide-store::shop-stocks.edition_stock') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shop_stocks.index') }}/{id}" store-data="editStock" @sended="AWES.emit('content::shop_stocks_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="shop_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input type="number" name="stock" label="{{ __('wide-store::shop-stocks.stock') }}"></fb-input>
            <fb-input name="availability" label="{{ __('wide-store::shop-stocks.availability') }}"></fb-input>
            <fb-input name="department" label="{{ __('wide-store::shop-stocks.department') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete shop stock--}}
    <modal-window name="delete-shop-stock" class="modal_formbuilder" title="{{ __('wide-store::shop-stocks.are_you_sure_delete_stock') }}">
        <form-builder name="delete-shop-stock" method="DELETE" url="{{ route('wide-store.shop_stocks.index') }}/{id}" store-data="deleteStock" @sended="AWES.emit('content::shop_stocks_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop-stock']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
