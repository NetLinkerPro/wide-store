@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::my-stocks.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::my-stocks.meta_description'))

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
            'name' => 'my_stocks_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.my_stocks.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::my-stocks.stock_list') }}</h3>
        </template>
        <tb-column name="no_field_integration_uuid" label="{{__('wide-store::my-stocks.integration') }}">
            <template slot-scope="col">
                @{{ col.data.integration.name }}
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
        <tb-column name="stock" label="{{__('wide-store::my-stocks.stock') }}">
            <template slot-scope="col">
                @{{ col.data.stock }}
            </template>
        </tb-column>
        <tb-column name="availability" label="{{__('wide-store::my-stocks.availability') }}">
            <template slot-scope="col">
                @{{ col.data.availability }}
            </template>
        </tb-column>
        <tb-column name="department" label="{{__('wide-store::my-stocks.department') }}">
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editStock', data: d.data}); AWES.emit('modal::edit-my-stock:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteStock', data: d.data}); AWES.emit('modal::delete-my-stock:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add my stock--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::my-stocks.addition_stock') }}">
        <form-builder name="add-my-stock" url="{{ route('wide-store.my_stocks.store') }}" @sended="AWES.emit('content::my_stocks_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-my-stock']">
                <fb-select name="integration_uuid" label="{{ __('wide-store::my-stocks.integration') }}"
                           url="{{route('wide-store.integrations.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input type="number" name="stock" label="{{ __('wide-store::my-stocks.stock') }}"></fb-input>
                <fb-input name="availability" label="{{ __('wide-store::my-stocks.availability') }}"></fb-input>
                <fb-input name="department" label="{{ __('wide-store::my-stocks.department') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit my stock--}}
    <modal-window name="edit-my-stock" class="modal_formbuilder" title="{{ __('wide-store::my-stocks.edition_stock') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.my_stocks.index') }}/{id}" store-data="editStock" @sended="AWES.emit('content::my_stocks_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="integration_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input type="number" name="stock" label="{{ __('wide-store::my-stocks.stock') }}"></fb-input>
            <fb-input name="availability" label="{{ __('wide-store::my-stocks.availability') }}"></fb-input>
            <fb-input name="department" label="{{ __('wide-store::my-stocks.department') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete my stock--}}
    <modal-window name="delete-my-stock" class="modal_formbuilder" title="{{ __('wide-store::my-stocks.are_you_sure_delete_stock') }}">
        <form-builder name="delete-my-stock" method="DELETE" url="{{ route('wide-store.my_stocks.index') }}/{id}" store-data="deleteStock" @sended="AWES.emit('content::my_stocks_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-my-stock']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
