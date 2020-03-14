@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::descriptions.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::descriptions.meta_description'))

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
                            <span>{{ __('wide-store::descriptions.manage') }}</span>
                        </template>
                        @include('wide-store::sections.partials.menu-manage')
                    </context-menu>
                </div>

            </div>
        </div>
    </div>
    <div class="section">
        @table([
            'name' => 'descriptions_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.descriptions.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::descriptions.description_list') }}</h3>
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
        <tb-column name="description" label="{{__('wide-store::descriptions.description') }}">
            <template slot-scope="col">
                @{{ col.data.description }}
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editDescription', data: d.data}); AWES.emit('modal::edit-description:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteDescription', data: d.data}); AWES.emit('modal::delete-description:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add description--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::descriptions.addition_description') }}">
        <form-builder name="add-description" url="{{ route('wide-store.descriptions.store') }}" @sended="AWES.emit('content::descriptions_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-description']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-textarea name="description" label="{{ __('wide-store::descriptions.description') }}"></fb-textarea>
                <fb-input name="lang" label="{{ __('wide-store::general.language') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit description--}}
    <modal-window name="edit-description" class="modal_formbuilder" title="{{ __('wide-store::descriptions.edition_description') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.descriptions.index') }}/{id}" store-data="editDescription" @sended="AWES.emit('content::descriptions_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-textarea name="description" label="{{ __('wide-store::descriptions.description') }}"></fb-textarea>
            <fb-input name="lang" label="{{ __('wide-store::general.language') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete description--}}
    <modal-window name="delete-description" class="modal_formbuilder" title="{{ __('wide-store::descriptions.are_you_sure_delete_description') }}">
        <form-builder name="delete-description" method="DELETE" url="{{ route('wide-store.descriptions.index') }}/{id}" store-data="deleteDescription" @sended="AWES.emit('content::descriptions_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-description']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
