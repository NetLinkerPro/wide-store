@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shop-images.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::shop-images.meta_description'))

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
            'name' => 'shop_images_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shop_images.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shop-images.image_list') }}</h3>
        </template>
        <tb-column name="no_field_shop_uuid" label="{{__('wide-store::shop-images.shop') }}">
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
        <tb-column name="identifier" label="{{__('wide-store::general.identifier') }}">
            <template slot-scope="col">
                @{{ col.data.identifier }}
            </template>
        </tb-column>
        <tb-column name="url_target" label="{{__('wide-store::shop-images.url_target') }}">
            <template slot-scope="col">
                @{{ col.data.url_target }}
            </template>
        </tb-column>
        <tb-column name="order" label="{{__('wide-store::shop-images.order') }}">
            <template slot-scope="col">
                @{{ col.data.order }}
            </template>
        </tb-column>
        <tb-column name="main" label="{{__('wide-store::shop-images.main') }}">
            <template slot-scope="col">
                <small v-if="col.data.main">{{__('wide-store::general.yes') }}</small>
                <small v-else>{{__('wide-store::general.no') }}</small>
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editImage', data: d.data}); AWES.emit('modal::edit-shop-image:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteImage', data: d.data}); AWES.emit('modal::delete-shop-image:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop image--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shop-images.addition_image') }}">
        <form-builder name="add-shop-image" url="{{ route('wide-store.shop_images.store') }}" @sended="AWES.emit('content::shop_images_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-shop-image']">

                <fb-select name="shop_uuid" label="{{ __('wide-store::shop-images.shop') }}"
                           url="{{route('wide-store.shops.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.shop_products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>

                <fb-input name="url_target" label="{{ __('wide-store::shop-images.url_target') }}"></fb-input>
                <fb-input type="number" name="order" label="{{ __('wide-store::shop-images.order') }}"></fb-input>

                <fb-switcher name="main" label="{{ __('wide-store::shop-images.main') }}"></fb-switcher>

            </div>
        </form-builder>
    </modal-window>

    {{--Edit shop image--}}
    <modal-window name="edit-shop-image" class="modal_formbuilder" title="{{ __('wide-store::shop-images.edition_image') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shop_images.index') }}/{id}" store-data="editImage" @sended="AWES.emit('content::shop_images_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="shop_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>

            <fb-input name="url_target" label="{{ __('wide-store::shop-images.url_target') }}"></fb-input>
            <fb-input type="number" name="order" label="{{ __('wide-store::shop-images.order') }}"></fb-input>

            <fb-switcher name="main" label="{{ __('wide-store::shop-images.main') }}"></fb-switcher>
        </form-builder>
    </modal-window>

    {{--Delete shop image--}}
    <modal-window name="delete-shop-image" class="modal_formbuilder" title="{{ __('wide-store::shop-images.are_you_sure_delete_image') }}">
        <form-builder name="delete-shop-image" method="DELETE" url="{{ route('wide-store.shop_images.index') }}/{id}" store-data="deleteImage" @sended="AWES.emit('content::shop_images_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop-image']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
