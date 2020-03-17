@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::integrations.meta_title')  . ' // ' . config('app.name'))
@section('meta_description', __('wide-store::integrations.meta_description'))

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
            'name' => 'integrations_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.integrations.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::integrations.integration_list') }}</h3>
        </template>
        <tb-column name="deliverer_configuration_uuid" label="{{__('wide-store::integrations.deliverer_configuration') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer_configuration_uuid }}
            </template>
        </tb-column>

        <tb-column name="deliverer" label="{{__('wide-store::general.deliverer') }}">
            <template slot-scope="col">
                @{{ col.data.deliverer }}
            </template>
        </tb-column>
            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editIntegration', data: d.data}); AWES.emit('modal::edit-integration:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteIntegration', data: d.data}); AWES.emit('modal::delete-integration:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add integration--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::integrations.addition_integration') }}">
        <form-builder name="add-integration" url="{{ route('wide-store.integrations.store') }}" @sended="AWES.emit('content::integrations_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-integration']">

                <fb-select name="deliverer" label="{{ __('wide-store::general.deliverer') }}"
                           url="{{route('wide-store.deliverers.scope')}}" auto-fetch="" taggable
                           options-value="value" options-name="name" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="deliverer_configuration_uuid" label="{{ __('wide-store::integrations.deliverer_configuration') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit integration--}}
    <modal-window name="edit-integration" class="modal_formbuilder" title="{{ __('wide-store::integrations.edition_integration') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.integrations.index') }}/{id}" store-data="editIntegration" @sended="AWES.emit('content::integrations_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="deliverer" label="{{ __('wide-store::general.deliverer') }}"></fb-input>
            <fb-input type="hidden" name="deliverer_configuration_uuid" label="{{ __('wide-store::integrations.deliverer_configuration') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete integration--}}
    <modal-window name="delete-integration" class="modal_formbuilder" title="{{ __('wide-store::integrations.are_you_sure_delete_integration') }}">
        <form-builder name="delete-integration" method="DELETE" url="{{ route('wide-store.integrations.index') }}/{id}" store-data="deleteIntegration" @sended="AWES.emit('content::integrations_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-integration']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
