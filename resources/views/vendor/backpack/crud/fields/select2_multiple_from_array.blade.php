<!-- select2 from array -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

        {{--
        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if((old($field['name']) && (
                        $key == old($field['name']) ||
                        (is_array(old($field['name'])) &&
                        in_array($key, old($field['name']))))) ||
                        (null === old($field['name']) &&
                            ((isset($field['value']) && (
                                        $key == $field['value'] || (
                                                is_array($field['value']) &&
                                                in_array($key, $field['value'])
                                                )
                                        )) ||
                                (isset($field['default']) &&
                                ($key == $field['default'] || (
                                                is_array($field['default']) &&
                                                in_array($key, $field['default'])
                                            )
                                        )
                                ))
                        ))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
        --}}

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if( (old($field["name"]) && in_array($key, old($field["name"]))) || (is_null(old($field["name"])) && isset($field['name'])))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2_multiple box
            $('.select2_multiple').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    var $obj = $(obj).select2({
                        theme: "bootstrap"
                    });

                    var options = [];
                    @if (isset($field['model']))
                        @foreach ($field['options'] as $key => $value)
                            options.push({{ $key }});
                        @endforeach
                    @endif

                    @if(isset($field['select_all']) && $field['select_all'])
                        $(obj).parent().find('.clear').on("click", function () {
                            $obj.val([]).trigger("change");
                        });
                        $(obj).parent().find('.select_all').on("click", function () {
                            $obj.val(options).trigger("change");
                        });
                    @endif
                }
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
