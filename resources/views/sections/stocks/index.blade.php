@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::stocks.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::stocks.meta_description'))

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
                <div class="filter__rlink">
                    <context-menu button-class="filter__slink" right>
                        <template slot="toggler">
                            <span>{{ __('wide-store::stocks.manage') }}</span>
                        </template>
                        <cm-link href="{{route('wide-store.identifiers.index')}}">   {{ __('wide-store::general.manage_identifiers') }}</cm-link>
                        <cm-link href="{{route('wide-store.products.index')}}">   {{ __('wide-store::general.manage_products') }}</cm-link>
                        <cm-link href="{{route('wide-store.names.index')}}">   {{ __('wide-store::general.manage_names') }}</cm-link>
                        <cm-link href="{{route('wide-store.urls.index')}}">   {{ __('wide-store::general.manage_urls') }}</cm-link>
                        <cm-link href="{{route('wide-store.prices.index')}}">   {{ __('wide-store::general.manage_prices') }}</cm-link>
                        <cm-link href="{{route('wide-store.taxes.index')}}">   {{ __('wide-store::general.manage_taxes') }}</cm-link>
{{--                        <cm-link href="{{route('wide-store.stocks.index')}}">   {{ __('wide-store::general.manage_stocks') }}</cm-link>--}}
                        <cm-link href="{{route('wide-store.categories.index')}}">   {{ __('wide-store::general.manage_categories') }}</cm-link>
                        <cm-link href="{{route('wide-store.product_categories.index')}}">   {{ __('wide-store::general.manage_product_categories') }}</cm-link>
                        <cm-link href="{{route('wide-store.images.index')}}">   {{ __('wide-store::general.manage_images') }}</cm-link>
                        <cm-link href="{{route('wide-store.descriptions.index')}}">   {{ __('wide-store::general.manage_descriptions') }}</cm-link>
                        <cm-link href="{{route('wide-store.attributes.index')}}">   {{ __('wide-store::general.manage_attributes') }}</cm-link>
                    </context-menu>
                </div>

            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'stocks_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.stocks.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::stocks.stock_list') }}</h3>
        </template>
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
        <tb-column name="stock" label="{{__('wide-store::stocks.stock') }}">
            <template slot-scope="col">
                @{{ col.data.stock }}
            </template>
        </tb-column>
        <tb-column name="availability" label="{{__('wide-store::stocks.availability') }}">
            <template slot-scope="col">
                @{{ col.data.availability }}
            </template>
        </tb-column>
        <tb-column name="department" label="{{__('wide-store::stocks.department') }}">
            <template slot-scope="col">
                @{{ col.data.department }}
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editStock', data: d.data}); AWES.emit('modal::edit-stock:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteStock', data: d.data}); AWES.emit('modal::delete-stock:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add stock--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::stocks.addition_stock') }}">
        <form-builder name="add-stock" url="{{ route('wide-store.stocks.store') }}" @sended="AWES.emit('content::stocks_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-stock']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input type="number" name="stock" label="{{ __('wide-store::stocks.stock') }}"></fb-input>
                <fb-input name="availability" label="{{ __('wide-store::stocks.availability') }}"></fb-input>
                <fb-input name="department" label="{{ __('wide-store::stocks.department') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit stock--}}
    <modal-window name="edit-stock" class="modal_formbuilder" title="{{ __('wide-store::stocks.edition_stock') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.stocks.index') }}/{id}" store-data="editStock" @sended="AWES.emit('content::stocks_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input type="number" name="stock" label="{{ __('wide-store::stocks.stock') }}"></fb-input>
            <fb-input name="availability" label="{{ __('wide-store::stocks.availability') }}"></fb-input>
            <fb-input name="department" label="{{ __('wide-store::stocks.department') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete stock--}}
    <modal-window name="delete-stock" class="modal_formbuilder" title="{{ __('wide-store::stocks.are_you_sure_delete_stock') }}">
        <form-builder name="delete-stock" method="DELETE" url="{{ route('wide-store.stocks.index') }}/{id}" store-data="deleteStock" @sended="AWES.emit('content::stocks_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-stock']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
