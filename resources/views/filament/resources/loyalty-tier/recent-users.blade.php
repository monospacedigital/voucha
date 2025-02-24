<div class="space-y-4">
    @php
        $users = is_callable($users) ? $users($get) : $users;
    @endphp

    @if($users->isEmpty())
        <div class="text-sm text-gray-500 dark:text-gray-400">
            No users in this tier yet.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Registration Date</th>
                        <th class="px-4 py-2 text-right">Points Balance</th>
                        <th class="px-4 py-2 text-right">Total Spent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->registration_date->format('M d, Y') }}</td>
                            <td class="px-4 py-2 text-right">
                                {{ number_format(
                                    $user->points->where('point_type', 'earned')->sum('point_value') -
                                    $user->points->where('point_type', 'redeemed')->sum('point_value')
                                ) }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                ₦{{ number_format($user->transactions->sum('transaction_amount'), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
