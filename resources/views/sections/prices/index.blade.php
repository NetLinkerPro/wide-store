@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::prices.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::prices.meta_description'))

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
                            <span>{{ __('wide-store::prices.manage') }}</span>
                        </template>
                        @include('wide-store::sections.partials.menu-manage')
                    </context-menu>
                </div>

            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'prices_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.prices.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::prices.price_list') }}</h3>
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
        <tb-column name="currency" label="{{__('wide-store::prices.currency') }}">
            <template slot-scope="col">
                @{{ col.data.currency }}
            </template>
        </tb-column>
        <tb-column name="price" label="{{__('wide-store::prices.price') }}">
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editPrice', data: d.data}); AWES.emit('modal::edit-price:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deletePrice', data: d.data}); AWES.emit('modal::delete-price:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add price--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::prices.addition_price') }}">
        <form-builder name="add-price" url="{{ route('wide-store.prices.store') }}" @sended="AWES.emit('content::prices_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-price']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="currency" label="{{ __('wide-store::prices.currency') }}"></fb-input>
                <fb-input name="price" label="{{ __('wide-store::prices.price') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit price--}}
    <modal-window name="edit-price" class="modal_formbuilder" title="{{ __('wide-store::prices.edition_price') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.prices.index') }}/{id}" store-data="editPrice" @sended="AWES.emit('content::prices_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="currency" label="{{ __('wide-store::prices.currency') }}"></fb-input>
            <fb-input name="price" label="{{ __('wide-store::prices.price') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete price--}}
    <modal-window name="delete-price" class="modal_formbuilder" title="{{ __('wide-store::prices.are_you_sure_delete_price') }}">
        <form-builder name="delete-price" method="DELETE" url="{{ route('wide-store.prices.index') }}/{id}" store-data="deletePrice" @sended="AWES.emit('content::prices_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-price']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
