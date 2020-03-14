@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::names.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::names.meta_description'))

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
                            <span>{{ __('wide-store::names.manage') }}</span>
                        </template>
                    @include('wide-store::sections.partials.menu-manage')
                    </context-menu>
                </div>

            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'names_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.names.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::names.name_list') }}</h3>
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
        <tb-column name="name" label="{{__('wide-store::general.name') }}">
            <template slot-scope="col">
                @{{ col.data.name }}
            </template>
        </tb-column>
        <tb-column name="lang" label="{{__('wide-store::general.language') }}">
            <template slot-scope="col">
                @{{ col.data.lang }}
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editName', data: d.data}); AWES.emit('modal::edit-name:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteName', data: d.data}); AWES.emit('modal::delete-name:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add name--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::names.addition_name') }}">
        <form-builder name="add-name" url="{{ route('wide-store.names.store') }}" @sended="AWES.emit('content::names_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-name']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
                <fb-input name="lang" label="{{ __('wide-store::general.language') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit name--}}
    <modal-window name="edit-name" class="modal_formbuilder" title="{{ __('wide-store::names.edition_name') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.names.index') }}/{id}" store-data="editName" @sended="AWES.emit('content::names_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="name" label="{{ __('wide-store::general.name') }}"></fb-input>
            <fb-input name="lang" label="{{ __('wide-store::general.language') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete name--}}
    <modal-window name="delete-name" class="modal_formbuilder" title="{{ __('wide-store::names.are_you_sure_delete_name') }}">
        <form-builder name="delete-name" method="DELETE" url="{{ route('wide-store.names.index') }}/{id}" store-data="deleteName" @sended="AWES.emit('content::names_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-name']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
