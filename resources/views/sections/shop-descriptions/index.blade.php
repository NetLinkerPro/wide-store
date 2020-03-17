@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shop-descriptions.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::shop-descriptions.meta_description'))

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
            'name' => 'shop_descriptions_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shop_descriptions.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shop-descriptions.description_list') }}</h3>
        </template>
        <tb-column name="no_field_shop_uuid" label="{{__('wide-store::shop-descriptions.shop') }}">
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
        <tb-column name="description" label="{{__('wide-store::shop-descriptions.description') }}">
            <template slot-scope="col">
                @{{ col.data.description }}
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editDescription', data: d.data}); AWES.emit('modal::edit-shop-description:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteDescription', data: d.data}); AWES.emit('modal::delete-shop-description:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop description--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shop-descriptions.addition_description') }}">
        <form-builder name="add-shop-description" url="{{ route('wide-store.shop_descriptions.store') }}" @sended="AWES.emit('content::shop_descriptions_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-shop-description']">

                <fb-select name="shop_uuid" label="{{ __('wide-store::shop-descriptions.shop') }}"
                           url="{{route('wide-store.shops.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.shop_products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-textarea name="description" label="{{ __('wide-store::shop-descriptions.description') }}"></fb-textarea>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit shop description--}}
    <modal-window name="edit-shop-description" class="modal_formbuilder" title="{{ __('wide-store::shop-descriptions.edition_description') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shop_descriptions.index') }}/{id}" store-data="editDescription" @sended="AWES.emit('content::shop_descriptions_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="shop_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-textarea name="description" label="{{ __('wide-store::shop-descriptions.description') }}"></fb-textarea>
        </form-builder>
    </modal-window>

    {{--Delete shop description--}}
    <modal-window name="delete-shop-description" class="modal_formbuilder" title="{{ __('wide-store::shop-descriptions.are_you_sure_delete_description') }}">
        <form-builder name="delete-shop-description" method="DELETE" url="{{ route('wide-store.shop_descriptions.index') }}/{id}" store-data="deleteDescription" @sended="AWES.emit('content::shop_descriptions_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop-description']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
