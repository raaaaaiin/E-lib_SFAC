<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info',"dark"] as $msg)
        @if(Session::has('alert-' . $msg))
            @php $messages = Session::get('alert-' . $msg); @endphp
            <div class="callout callout-{{ $msg }}">
                <button type="button" class="close closeCallout"><span
                        aria-hidden="true">&times;</span>
                </button>
                @if(is_array($messages))
                    @foreach($messages as $smsg)
                        <span>{{ $smsg[0]}}</span>
                    @endforeach
                @else
                    {{ $messages }}
                @endif
            </div>
        @endif
    @endforeach
</div>
