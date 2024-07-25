@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'labelClass' => '',
    'selectClass' => '',
    'igroupSize' => 'md',
    'placeholder' => 'Select an option...',
    'ajaxRoute' => '',
    'options' => [],
    'selected' => null,
    'useAjax' => false,
    'template' => ['id' => 'id', 'text' => 'name'] // Adding template as prop
])

<div class="form-group">
    @isset($label)
        <label for="#{{ $id }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endisset
    <div class="input-group input-group-{{ $igroupSize }}">

        <select id="{{ $id }}" name="{{ $name }}" class="form-control select2 {{ $selectClass }}">
            @unless($useAjax)
                @foreach($options as $option)
                    <option value="{{ $option[$template['id']] }}" {{ (old($name, $selected ?? "") == $option[$template['id']]) ? 'selected' : '' }}>
                        {{ $option[$template['text']] }}
                    </option>
                @endforeach
            @endunless
        </select>

    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            @if($useAjax)
                $('#{{ $id }}').select2({
                    width: '100%',
                    theme: 'bootstrap4',
                    ajax: {
                        url: "{{ $ajaxRoute }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page || 1
                            };
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processResults: function(data) {
                            return {
                                results: data.data.map(function(item) {
                                    return {
                                        id: item['{{ $template['id'] }}'],
                                        text: item['{{ $template['text'] }}']
                                    };
                                }),
                                pagination: {
                                    more: data.current_page < data.last_page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: '{{ $placeholder }}'

                });

                @if(!empty($options))
                    @foreach($options as $option)
                        var option = new Option("{{ $option['text'] }}", "{{ $option['id'] }}", true, true);
                        $('#{{ $id }}').append(option).trigger('change');
                    @endforeach
                @endif
            @else
                $('#{{ $id }}').select2({
                    width: '100%',
                    theme: 'bootstrap4',
                    placeholder: '{{ $placeholder }}'
                });

            @endif
        });
    </script>
@endpush

