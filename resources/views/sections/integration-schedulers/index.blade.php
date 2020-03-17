@extends('wide-store::vendor.indigo-layout.main')

@section('meta_title', __('wide-store::integration-schedulers.meta_title')  . ' // ' . config('app.url'))
@section('meta_description', __('wide-store::integration-schedulers.meta_description'))

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
            'name' => 'integration_schedulers_table',
            'row_url'=> '',
            'scope_api_url' => route('wide-store.integration_schedulers.scope'),
            'scope_api_params' => []
        ])
        <template slot="header">
            <h3>{{__('wide-store::integration-schedulers.integration_scheduler_list') }}</h3>
        </template>
        <tb-column name="integration_uuid" label="{{__('wide-store::integration-schedulers.integration') }}">
            <template slot-scope="col">
                @{{ col.data.integration_uuid }}
            </template>
        </tb-column>
        <tb-column name="cron" label="{{__('wide-store::integration-schedulers.cron') }}">
            <template slot-scope="col">
                @{{ col.data.cron }}
            </template>
        </tb-column>

            <tb-column name="no_field_options" label="{{ __('wide-store::general.options') }}">
                <template slot-scope="d">
                    <context-menu right boundary="table">
                        <button type="submit" slot="toggler" class="btn">
                            {{ __('wide-store::general.options') }}
                        </button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'editIntegrationScheduler', data: d.data}); AWES.emit('modal::edit-integration-scheduler:open')">
                            {{ __('wide-store::general.edit') }}
                        </cm-button>
                        <cm-button @click="AWES._store.commit('setData', {param: 'deleteIntegrationScheduler', data: d.data}); AWES.emit('modal::delete-integration-scheduler:open');">
                            {{ __('wide-store::general.delete') }}
                        </cm-button>
                    </context-menu>
                </template>
            </tb-column>
        @endtable
    </div>
@endsection

@section('modals')

    {{--Add integration-scheduler--}}
    <modal-window name="form" class="modal_formbuilder" title="{{ __('wide-store::integration-schedulers.addition_integration_scheduler') }}">
        <form-builder name="add-integration-scheduler" url="{{ route('wide-store.integration_schedulers.store') }}" @sended="AWES.emit('content::integration_schedulers_table:update')"
                      send-text="{{ __('wide-store::general.add') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">
            <div class="section" v-if="AWES._store.state.forms['add-integration-scheduler']">

                <fb-select name="integration_uuid" label="{{ __('wide-store::integration-schedulers.integration') }}"
                           url="{{route('wide-store.integrations.scope')}}" auto-fetch=""
                           options-value="uuid" options-name="uuid" :multiple="false" placeholder-text=" "></fb-select>

                <fb-input name="cron" label="{{ __('wide-store::integration-schedulers.cron') }}"></fb-input>
            </div>
        </form-builder>
    </modal-window>

    {{--Edit integration-scheduler--}}
    <modal-window name="edit-integration-scheduler" class="modal_formbuilder" title="{{ __('wide-store::integration-schedulers.edition_integration_scheduler') }}">
        <form-builder method="PATCH" url="{{ route('wide-store.integration_schedulers.index') }}/{id}" store-data="editIntegrationScheduler" @sended="AWES.emit('content::integration_schedulers_table:update')"
                      send-text="{{ __('wide-store::general.save') }}"
                      cancel-text="{{ __('wide-store::general.cancel') }}">

            <fb-input type="hidden" name="integration_uuid"></fb-input>
            <fb-input name="cron" label="{{ __('wide-store::integration-schedulers.cron') }}"></fb-input>
        </form-builder>
    </modal-window>

    {{--Delete integration-scheduler--}}
    <modal-window name="delete-integration-scheduler" class="modal_formbuilder" title="{{ __('wide-store::integration-schedulers.are_you_sure_delete_integration_scheduler') }}">
        <form-builder name="delete-integration-scheduler" method="DELETE" url="{{ route('wide-store.integration_schedulers.index') }}/{id}" store-data="deleteIntegrationScheduler" @sended="AWES.emit('content::integration_schedulers_table:update')"
                      send-text="{{ __('wide-store::general.yes') }}"
                      cancel-text="{{ __('wide-store::general.no') }}"
                      disabled-dialog>
            <template slot-scope="block">

                <!-- Fix enable button yes for delete -->
                <input type="hidden" name="isEdited" :value="AWES._store.state.forms['delete-integration-scheduler']['isEdited'] = true"/>
            </template>
        </form-builder>
    </modal-window>

@endsection
