@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shop-attributes.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::shop-attributes.meta_description'))

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
            'name' => 'shop_attributes_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shop_attributes.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shop-attributes.attribute_list') }}</h3>
        </template>
        <tb-column name="no_field_shop_uuid" label="{{__('wide-store::shop-attributes.shop') }}">
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
        <tb-column name="name" label="{{__('wide-store::general.name') }}">
            <template slot-scope="col">
                @{{ col.data.name }}
            </template>
        </tb-column>
        <tb-column name="value" label="{{__('wide-store::shop-attributes.value') }}">
            <template slot-scope="col">
                @{{ col.data.value }}
            </template>
        </tb-column>
        <tb-column name="order" label="{{__('wide-store::shop-attributes.order') }}">
            <template slot-scope="col">
                @{{ col.data.order }}
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editAttribute', data: d.data}); AWES.emit('modal::edit-shop-attribute:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteAttribute', data: d.data}); AWES.emit('modal::delete-shop-attribute:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop attribute--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shop-attributes.addition_attribute') }}">
        <form-builder name="add-shop-attribute" url="{{ route('wide-store.shop_attributes.store') }}" @sended="AWES.emit('content::shop_attributes_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-shop-attribute']">

                <fb-select name="shop_uuid" label="{{ __('wide-store::shop-attributes.shop') }}"
                           url="{{route('wide-store.shops.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.shop_products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-input name="value" label="{{ __('wide-store::shop-attributes.value') }}"></fb-input>
                <fb-input type="number" name="order" label="{{ __('wide-store::shop-attributes.order') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit shop attribute--}}
    <modal-window name="edit-shop-attribute" class="modal_formbuilder" title="{{ __('wide-store::shop-attributes.edition_attribute') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shop_attributes.index') }}/{id}" store-data="editAttribute" @sended="AWES.emit('content::shop_attributes_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="shop_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-input name="value" label="{{ __('wide-store::shop-attributes.value') }}"></fb-input>
            <fb-input type="number" name="order" label="{{ __('wide-store::shop-attributes.order') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete shop attribute--}}
    <modal-window name="delete-shop-attribute" class="modal_formbuilder" title="{{ __('wide-store::shop-attributes.are_you_sure_delete_attribute') }}">
        <form-builder name="delete-shop-attribute" method="DELETE" url="{{ route('wide-store.shop_attributes.index') }}/{id}" store-data="deleteAttribute" @sended="AWES.emit('content::shop_attributes_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop-attribute']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
