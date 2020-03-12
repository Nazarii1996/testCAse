@extends('layouts.admin')
@section('content')
<div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.projects.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.project.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif

                </div>
                <div class="form-group">
                    <label class="required">Description</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"  name="description" id="description"  required></textarea> @if($errors->has('description'))

                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif

                </div>
                <div class="form-group">
                    <label for="organiztion">{{ trans('cruds.project.fields.organiztion') }}</label>
                    <input class="form-control {{ $errors->has('organiztion') ? 'is-invalid' : '' }}" type="text" name="organiztion" id="organiztion" value="{{ old('organiztion', '') }}">
                    @if($errors->has('organiztion'))
                        <span class="text-danger">{{ $errors->first('organiztion') }}</span>
                    @endif
                        </div>
                <div class="form-group">
                    <label for="start">{{ trans('cruds.project.fields.start') }}</label>
                    <input class="form-control date {{ $errors->has('start') ? 'is-invalid' : '' }}" type="text" name="start" id="start" value="{{ old('start') }}">
                    @if($errors->has('start'))
                        <span class="text-danger">{{ $errors->first('start') }}</span>
                    @endif
                    </div>
                <div class="form-group">
                    <label for="end">{{ trans('cruds.project.fields.end') }}</label>
                    <input class="form-control date {{ $errors->has('end') ? 'is-invalid' : '' }}" type="text" name="end" id="end" value="{{ old('end') }}">
                    @if($errors->has('end'))
                        <span class="text-danger">{{ $errors->first('end') }}</span>
                    @endif
                      </div>
                <div class="form-group">
                    <label for="skills">{{ trans('cruds.project.fields.skills') }}</label>
                    <input id="input-tags" class="form-control" name="skills" id="skills" value="{{ old('skills') }}">
                    @if($errors->has('end'))
                        <span class="text-danger">{{ $errors->first('end') }}</span>
                    @endif
                      </div>
                <div class="form-group">
                    <label for="role">{{ trans('cruds.project.fields.role') }}</label>
                    <input class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" type="text" name="role" id="role" value="{{ old('role', '') }}">
                    @if($errors->has('role'))
                        <span class="text-danger">{{ $errors->first('role') }}</span>
                    @endif
                       </div>
                <div class="form-group">
                    <label for="link">{{ trans('cruds.project.fields.link') }}</label>
                    <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', '') }}">
                    @if($errors->has('link'))
                        <span class="text-danger">{{ $errors->first('link') }}</span>
                    @endif
                      </div>
                <div class="form-group">
                    <label for="attachments">{{ trans('cruds.project.fields.attachments') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                    </div>
                    @if($errors->has('attachments'))
                        <span class="text-danger">{{ $errors->first('attachments') }}</span>
                    @endif
                  </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.project.fields.type') }}</label>
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                        <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Project::TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                    </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        var uploadedAttachmentsMap = {}
        Dropzone.options.attachmentsDropzone = {
            url: '{{ route('admin.projects.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
                uploadedAttachmentsMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAttachmentsMap[file.name]
                }
                $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
            },
            init: function () {
                    @if(isset($project) && $project->attachments)
                var files =
                {!! json_encode($project->attachments) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.5/js/standalone/selectize.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.5/css/selectize.bootstrap3.min.css">
    <script>
        $('#input-tags').selectize({
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });
    </script>
@endsection
