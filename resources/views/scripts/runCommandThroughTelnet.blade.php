{{-- A bit iffy when latency comes into play --}}
( sleep 2; echo {!! escapeshellarg($adminName) !!}; sleep 2; echo {!! escapeshellarg($adminPassword) !!}; sleep 2; echo {!! escapeshellarg($command) !!}; sleep 5; ) | nc --telnet -c {{ $address }} {{ $port }}
