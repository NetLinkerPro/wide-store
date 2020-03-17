@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::product-categories.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::product-categories.meta_description'))

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
            'name' => 'product_categories_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.product_categories.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::product-categories.product_category_list') }}</h3>
        </template>
        <tb-column name="no_field_product_uuid" label="{{__('wide-store::general.product') }}">
            <template slot-scope="col">
                @{{ col.data.product.name }}
            </template>
        </tb-column>
        <tb-column name="no_field_category_uuid" label="{{__('wide-store::categories.category') }}">
            <template slot-scope="col">
                @{{ col.data.category.name }}
            </template>
        </tb-column>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="type" label="{{__('wide-store::general.type') }}">
            <template slot-scope="col">
                @{{ col.data.type }}
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editProductCategory', data: d.data}); AWES.emit('modal::edit-product-category:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteProductCategory', data: d.data}); AWES.emit('modal::delete-product-category:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add product-category--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::product-categories.addition_product_category') }}">
        <form-builder name="add-product-category" url="{{ route('wide-store.product_categories.store') }}" @sended="AWES.emit('content::product_categories_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-product-category']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>
                <fb-select name="category_uuid" label="{{ __('wide-store::categories.category') }}"
                           url="{{route('wide-store.categories.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>
                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit product-category--}}
    <modal-window name="edit-product-category" class="modal_formbuilder" title="{{ __('wide-store::product-categories.edition_product_category') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.product_categories.index') }}/{id}" store-data="editProductCategory" @sended="AWES.emit('content::product_categories_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input type="hidden" name="category_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete product-category--}}
    <modal-window name="delete-product-category" class="modal_formbuilder" title="{{ __('wide-store::product-categories.are_you_sure_delete_product_category') }}">
        <form-builder name="delete-product-category" method="DELETE" url="{{ route('wide-store.product_categories.index') }}/{id}" store-data="deleteProductCategory" @sended="AWES.emit('content::product_categories_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-product-category']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
