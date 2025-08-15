<div class="bg-white p-10 rounded-md">
<div class="flex justify-between mb-5">
    <button wire:click="previousWeek" class="px-4 py-2 bg-gray-300 rounded">Previous Week</button>
    <span class="font-bold text-lg">Week of {{ \Carbon\Carbon::parse($weekDays->first())->format('d M Y') }}</span>
    <button wire:click="nextWeek" class="px-4 py-2 bg-gray-300 rounded">Next Week</button>
</div>
<div class="grid grid-cols-8 gap-4">

    <div class="font-bold">Time\Day</div>
    @foreach($weekDays as $day)
        <div class="font-bold">{{ \Carbon\Carbon::parse($day)->format('D d M') }}</div>
    @endforeach

    @foreach($timeSlots as $slot)
        <div class="font-bold">{{ \Carbon\Carbon::parse($slot)->format('H:i') }}</div>

        @foreach($weekDays as $day)
            @php
                $booked = $this->isSlotBooked($day, $slot);
                $blocked = $this->isSlotBlocked($day, $slot);
            @endphp
            <div
                wire:click="toggleBlock('{{ $day }}', '{{ $slot }}')"
                class="cursor-pointer p-2 border text-center
                    {{ $booked ? 'bg-red-400 text-white' : '' }}
                    {{ $blocked && !$booked ? 'bg-gray-400 text-white' : '' }}
                    {{ !$booked && !$blocked ? 'bg-green-200' : '' }}"
            >
                @if($booked)
                    Booked
                @elseif($blocked)
                    Blocked
                @else
                    Available
                @endif
            </div>
        @endforeach
    @endforeach
</div>

</div>
