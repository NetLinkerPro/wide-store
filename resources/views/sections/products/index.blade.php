@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::products.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::products.meta_description'))

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
            'name' => 'products_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.products.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::products.product_list') }}</h3>
        </template>
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
        <tb-column name="active" label="{{__('wide-store::general.active') }}">
            <template slot-scope="col">
                <span v-if="col.data.active">{{__('wide-store::general.yes') }}</span>
                <span v-else>{{__('wide-store::general.no') }}</span>
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editProduct', data: d.data}); AWES.emit('modal::edit-product:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteProduct', data: d.data}); AWES.emit('modal::delete-product:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add product--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::products.addition_product') }}">
        <form-builder name="add-product" url="{{ route('wide-store.products.store') }}" @sended="AWES.emit('content::products_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-product']">

                <fb-select name="category_uuid" label="{{ __('wide-store::categories.category') }}"
                           url="{{route('wide-store.categories.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-switcher name="active" label="{{ __('wide-store::general.active') }}"></fb-switcher>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit product--}}
    <modal-window name="edit-product" class="modal_formbuilder" title="{{ __('wide-store::products.edition_product') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.products.index') }}/{id}" store-data="editProduct" @sended="AWES.emit('content::products_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="category_uuid"></fb-input>
            <fb-input name="identifier" label="{{ __('wide-store::general.identifier') }}"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-switcher name="active" label="{{ __('wide-store::general.active') }}"></fb-switcher>
        </form-builder>
    </modal-window>

    {{--Delete product--}}
    <modal-window name="delete-product" class="modal_formbuilder" title="{{ __('wide-store::products.are_you_sure_delete_product') }}">
        <form-builder name="delete-product" method="DELETE" url="{{ route('wide-store.products.index') }}/{id}" store-data="deleteProduct" @sended="AWES.emit('content::products_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-product']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
