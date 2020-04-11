@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::shops.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::shops.meta_description'))

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
            'name' => 'shops_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.shops.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::shops.shop_list') }}</h3>
        </template>
        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
        <tb-column name="no_field_formatter_uuid" label="{{__('wide-store::shops.formatter') }}">
            <template slot-scope="col">
                @{{ col.data.formatter.name }}
            </template>
        </tb-column>
        <tb-column name="no_field_configuration" label="{{__('wide-store::shops.configuration') }}">
            <template slot-scope="col">
                <div v-if="col.data.configuration">
                    @{{ col.data.configuration.name }}
                </div>
            </template>
        </tb-column>
        <tb-column name="name" label="{{__('wide-store::general.name') }}">
            <template slot-scope="col">
                @{{ col.data.name }}
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editShop', data: d.data}); AWES.emit('modal::edit-shop:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteShop', data: d.data}); AWES.emit('modal::delete-shop:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add shop--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::shops.addition_shop') }}">
        <form-builder name="add-shop" url="{{ route('wide-store.shops.store') }}" @sended="AWES.emit('content::shops_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <div v-if="AWES._store.state.forms['add-shop']">

                <fb-select name="deliverer" label="{{ __('wide-store::general.deliverer') }}"
                           url="{{route('wide-store.deliverers.scope')}}?q=%s" auto-fetch=""
                           :disabled="!!AWES._store.state.forms['add-shop'].fields.deliverer"
                           options-value="value" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <div v-if="AWES._store.state.forms['add-shop'].fields.deliverer" class="mt-10">

                    <fb-select name="formatter_uuid" label="{{ __('wide-store::shops.formatter') }}"
                               :url="'{{route('wide-store.formatters.scope')}}?q=%s&module='
                                + AWES._store.state.forms['add-shop'].fields.deliverer" auto-fetch=""
                               options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                    <fb-select name="configuration_uuid" label="{{ __('wide-store::shops.formatter') }}"
                               :url="'{{route('wide-store.configuration.scope')}}?q=%s&module='
                                + AWES._store.state.forms['add-shop'].fields.deliverer" auto-fetch=""
                               options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                    <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                    <fb-textarea name="description" label="{{ __('wide-store::general.description') }}"></fb-textarea>

                </div>

            </div>

        </form-builder>
    </modal-window>

    {{--Edit shop--}}
    <modal-window name="edit-shop" class="modal_formbuilder" title="{{ __('wide-store::shops.edition_shop') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.shops.index') }}/{id}" store-data="editShop" @sended="AWES.emit('content::shops_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="deliverer"></fb-input>
            <fb-input type="hidden" name="formatter_uuid"></fb-input>
            <fb-input type="hidden" name="configuration_uuid"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-textarea name="description" label="{{ __('wide-store::general.description') }}"></fb-textarea>
        </form-builder>
    </modal-window>

    {{--Delete shop--}}
    <modal-window name="delete-shop" class="modal_formbuilder" title="{{ __('wide-store::shops.are_you_sure_delete_shop') }}">
        <form-builder name="delete-shop" method="DELETE" url="{{ route('wide-store.shops.index') }}/{id}" store-data="deleteShop" @sended="AWES.emit('content::shops_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-shop']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
