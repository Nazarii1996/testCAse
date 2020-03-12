@extends('layouts.admin')
@section('content')
    @can('project_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.projects.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card" id="app">
        <div class="card-header" >
            {{ trans('cruds.project.title_singular') }} {{ trans('global.list') }}
        </div>
    @can('sort_projects')
      <div class="panel">
          <div class="col-md-3">
              <label for="" class="col-form-label">Title</label>
          <input v-model="title" type="text" class="form-control">
          </div>
      </div>
    @endcan

        <div class="card-body" >

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Project">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.project.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.project.fields.organiztion') }}
                        </th>


                        <th>
                            {{ trans('cruds.project.fields.type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(project,index) in projects" :data-entry-id="project.id">
                            <td>

                            </td>
                            <td>
                                @{{ project.id }}
                            </td>
                            <td>
                                @{{ project.title }}
                            </td>
                            <td>
                                @{{ project.description}}
                            </td>
                            <td>
                                @{{ project.organiztion }}
                            </td>

                            <td>
                                @{{ project.type }}
                            </td>
                            <td>
                                @can('project_show')
                                    <a class="btn btn-xs btn-primary" :href="project.show">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('project_edit')
                                    <a class="btn btn-xs btn-info" :href="project.edit">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('project_delete')
                                    <form :action="project.remove" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {

                projects:[],
                title:"",
            },
            mounted(){
                axios.get('http://127.0.0.1:8000/api/v1/projects').then(responce=>(this.projects=responce.data))

            },
            methods:{
              filter:function(e){
                  axios.get('http://127.0.0.1:8000/api/v1/projects',{params:{title:this.title}}).then(responce=>(this.projects=responce.data))
              }
            },
            watch:{
                title:function(val){
                   this.filter();
                }
            }
        })
    </script>
@endsection
