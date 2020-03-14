@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::urls.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::urls.meta_description'))

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
                            <span>{{ __('wide-store::urls.manage') }}</span>
                        </template>
                        <cm-link href="{{route('wide-store.identifiers.index')}}">   {{ __('wide-store::general.manage_identifiers') }}</cm-link>
                        <cm-link href="{{route('wide-store.products.index')}}">   {{ __('wide-store::general.manage_products') }}</cm-link>
                        <cm-link href="{{route('wide-store.names.index')}}">   {{ __('wide-store::general.manage_names') }}</cm-link>
{{--                        <cm-link href="{{route('wide-store.urls.index')}}">   {{ __('wide-store::general.manage_urls') }}</cm-link>--}}
                        <cm-link href="{{route('wide-store.prices.index')}}">   {{ __('wide-store::general.manage_prices') }}</cm-link>
                        <cm-link href="{{route('wide-store.taxes.index')}}">   {{ __('wide-store::general.manage_taxes') }}</cm-link>
                        <cm-link href="{{route('wide-store.stocks.index')}}">   {{ __('wide-store::general.manage_stocks') }}</cm-link>
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
            'name' => 'urls_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.urls.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::urls.url_list') }}</h3>
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
        <tb-column name="url" label="{{__('wide-store::general.url') }}">
            <template slot-scope="col">
                @{{ col.data.url }}
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
                        <cm-button @click="AWES._store.commit('setData', {param: 'editUrl', data: d.data}); AWES.emit('modal::edit-url:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteUrl', data: d.data}); AWES.emit('modal::delete-url:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add url--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::urls.addition_url') }}">
        <form-builder name="add-url" url="{{ route('wide-store.urls.store') }}" @sended="AWES.emit('content::urls_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-url']">
                <fb-select name="product_uuid" label="{{ __('wide-store::general.product') }}"
                           url="{{route('wide-store.products.scope')}}?q=%s"
                           options-value="uuid" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
                <fb-input name="url" label="{{ __('wide-store::general.url') }}"></fb-input>
                <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit url--}}
    <modal-window name="edit-url" class="modal_formbuilder" title="{{ __('wide-store::urls.edition_url') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.urls.index') }}/{id}" store-data="editUrl" @sended="AWES.emit('content::urls_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="product_uuid"></fb-input>
            <fb-input name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input name="url" label="{{ __('wide-store::general.url') }}"></fb-input>
            <fb-input name="type" label="{{ __('wide-store::general.type') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete url--}}
    <modal-window name="delete-url" class="modal_formbuilder" title="{{ __('wide-store::urls.are_you_sure_delete_url') }}">
        <form-builder name="delete-url" method="DELETE" url="{{ route('wide-store.urls.index') }}/{id}" store-data="deleteUrl" @sended="AWES.emit('content::urls_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-url']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
