@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" />
    <style>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
        }

        .dropzone .dz-message {
            font-weight: 400;
        }

        .dropzone .dz-message .note {
            font-size: 0.8em;
            font-weight: 200;
            display: block;
            margin-top: 1.4rem;
        }
    </style>
    <h2 class="card-title d-none">{{ _lang('Add New') }}</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" autocomplete="off" action="{{ route('promotions.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Description') }}</label>
                                    <textarea rows="4" class="form-control" name="description" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Promotion Type') }}</label>
                                    <select class="form-control select2" name="promotion_type"
                                        data-selected="{{ old('promotion_type', 'image') }}">
                                        <option value="image">{{ _lang('Image') }}</option>
                                        <option value="video">{{ _lang('Video') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Image') }}</label>
                                    <input type="file" class="form-control dropify" name="image"
                                        data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                </div>
                            </div>

                            <div class="col-md-12 d-none">
                                <div class="form-group">
                                    <label class="form-control-label">{{ _lang('Video') }}</label>
                                    <div class="text-center">
                                        <div action="{{ url('promotions/video') }}" class="dropzone"
                                            id="my-awesome-dropzone">
                                            <input type="file" name="file" style="display: none;">
                                            <input type="hidden" name="video">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Action Url') }}</label>
                                    <input type="text" class="form-control" name="action_url"
                                        value="{{ old('action_url') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Status') }}</label>
                                    <select class="form-control select2" name="status" required>
                                        <option value="1">{{ _lang('Active') }}</option>
                                        <option value="0">{{ _lang('In-Active') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger btn-sm">{{ _lang('Reset') }}</button>
                                    <button type="submit" class="btn btn-primary btn-sm">{{ _lang('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        var $ = window.$;

        if ($("#my-awesome-dropzone").length > 0) {
            var token = $('input[name=_token]').val();
            var myDropzone = new Dropzone("#my-awesome-dropzone", {
                url: "{{ url('promotions/video') }}",
                chunking: true,
                method: "POST",
                maxFilesize: 400000000,
                chunkSize: 1000000,
                acceptedFiles: ".mp4,.mkv,.avi",
                parallelChunkUploads: true,
                // /addRemoveLinks: true,
                //maxFiles:1,
                // init: function() {
                //  this.hiddenFileInput.removeAttribute('multiple');
                // }
            });
            myDropzone.on('sending', function(file, xhr, formData) {
                formData.append("_token", token);
                var dropzoneOnLoad = xhr.onload;
                xhr.onload = function(e) {
                    dropzoneOnLoad(e)
                    // var uploadResponse = JSON.parse(xhr.responseText)
                    // if (typeof uploadResponse.name === 'string') {
                    //  $list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name + '</li>')
                    // }
                }
            })
            myDropzone.on('success', function(file, response) {
                console.log('response');
                $('[name=video]').val(response['path'] + response['name']);
                return file.previewElement.classList.add("dz-success");
            })
            myDropzone.on('error', function(file, errorMessage) {
                console.log(errorMessage);
            })

            $('input[name=file]').on('change', function() {
                if (typeof this.files[0] === 'object') {
                    myDropzone.addFile(this.files[0]);
                }
            });
            var $list = $('#file-upload-list');
            myDropzone.on('addedfile', function() {

            })
        }
    </script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
    <script type="text/javascript">
        $('[name=promotion_type]').on('change', function() {
            $('[name=image]').closest('.col-md-12').addClass('d-none');
            $('[name=video]').closest('.col-md-12').addClass('d-none');

            if ($(this).val() == 'image') {
                $('[name=image]').closest('.col-md-12').removeClass('d-none');
            } else {
                $('[name=video]').closest('.col-md-12').removeClass('d-none');
            }
        });
    </script>
@endsection
