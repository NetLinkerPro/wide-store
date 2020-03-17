@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::taxes.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::taxes.meta_description'))

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
            'name' => 'taxes_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.taxes.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::taxes.tax_list') }}</h3>
        </template>
        <tb-column name="no_field_product_uuid" label="{{__('wide-store::general.product') }}">
            <template slot-scope="col">
                @{{ col.data.product.name }}
            </template>
        </tb-column>
        <tb-column name="country" label="{{__('wide-store::general.country') }}">
            <template slot-scope="col">
                @{{ col.data.country }}
            </template>
        </tb-column>
        <tb-column name="tax" label="{{__('wide-store::general.tax') }}">
            <template slot-scope="col">
                @{{ col.data.tax }}
            </template>
        </tb-column>
              <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editTax', data: d.data}); AWES.emit('modal::edit-tax:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteTax', data: d.data}); AWES.emit('modal::delete-tax:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add tax--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::taxes.addition_tax') }}">
        <form-builder name="add-tax" url="{{ route('wide-store.taxes.store') }}" @sended="AWES.emit('content::taxes_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-tax']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="country" label="{{ __('wide-store::general.country') }}"></fb-input>
                <fb-input name="tax" label="{{ __('wide-store::general.tax') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit tax--}}
    <modal-window name="edit-tax" class="modal_formbuilder" title="{{ __('wide-store::taxes.edition_tax') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.taxes.index') }}/{id}" store-data="editTax" @sended="AWES.emit('content::taxes_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="country" label="{{ __('wide-store::general.country') }}"></fb-input>
            <fb-input name="tax" label="{{ __('wide-store::general.tax') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete tax--}}
    <modal-window name="delete-tax" class="modal_formbuilder" title="{{ __('wide-store::taxes.are_you_sure_delete_tax') }}">
        <form-builder name="delete-tax" method="DELETE" url="{{ route('wide-store.taxes.index') }}/{id}" store-data="deleteTax" @sended="AWES.emit('content::taxes_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-tax']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
