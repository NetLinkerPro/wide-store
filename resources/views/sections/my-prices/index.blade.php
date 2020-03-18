@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::my-prices.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::my-prices.meta_description'))

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
            'name' => 'my_prices_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.my_prices.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::my-prices.price_list') }}</h3>
        </template>
        <tb-column name="no_field_configuration_uuid" label="{{__('wide-store::my-prices.configuration') }}">
            <template slot-scope="col">
                @{{ col.data.configuration.name }}
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
        <tb-column name="currency" label="{{__('wide-store::my-prices.currency') }}">
            <template slot-scope="col">
                @{{ col.data.currency }}
            </template>
        </tb-column>
        <tb-column name="price" label="{{__('wide-store::my-prices.price') }}">
            <template slot-scope="col">
                @{{ col.data.price }}
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editPrice', data: d.data}); AWES.emit('modal::edit-my-price:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deletePrice', data: d.data}); AWES.emit('modal::delete-my-price:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add my price--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::my-prices.addition_price') }}">
        <form-builder name="add-my-price" url="{{ route('wide-store.my_prices.store') }}" @sended="AWES.emit('content::my_prices_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <div class="section" v-if="AWES._store.state.forms['add-my-price']">

                <fb-select name="deliverer" label="{{ __('wide-store::general.deliverer') }}"
                           url="{{route('wide-store.deliverers.scope')}}?q=%s" auto-fetch=""
                           :disabled="!!AWES._store.state.forms['add-my-price'].fields.deliverer"
                           options-value="value" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <div v-if="AWES._store.state.forms['add-my-price'].fields.deliverer" class="mt-10">

                    <fb-select name="configuration_uuid" label="{{ __('wide-store::my-prices.configuration') }}"
                               :url="'{{route('wide-store.configurations.scope')}}?q=%s&module='
                                + AWES._store.state.forms['add-my-price'].fields.deliverer" auto-fetch=""
                               options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                    <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                               :url="'{{route('wide-store.products.scope')}}?q=%s&deliverer='
                                + AWES._store.state.forms['add-my-price'].fields.deliverer"
                               options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                    <fb-input name="currency" label="{{ __('wide-store::my-prices.currency') }}"></fb-input>
                    <fb-input name="price" label="{{ __('wide-store::my-prices.price') }}"></fb-input>
                    <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
                </div>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit my price--}}
    <modal-window name="edit-my-price" class="modal_formbuilder" title="{{ __('wide-store::my-prices.edition_price') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.my_prices.index') }}/{id}" store-data="editPrice" @sended="AWES.emit('content::my_prices_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="deliverer"></fb-input>
            <fb-input type="hidden" name="configuration_uuid"></fb-input>
            <fb-input type="hidden" name="product_uuid"></fb-input>

            <fb-input name="currency" label="{{ __('wide-store::my-prices.currency') }}"></fb-input>
            <fb-input name="price" label="{{ __('wide-store::my-prices.price') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete my price--}}
    <modal-window name="delete-my-price" class="modal_formbuilder" title="{{ __('wide-store::my-prices.are_you_sure_delete_price') }}">
        <form-builder name="delete-my-price" method="DELETE" url="{{ route('wide-store.my_prices.index') }}/{id}" store-data="deletePrice" @sended="AWES.emit('content::my_prices_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-my-price']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
