<x-app-layout>
    <div class="max-w-3xl mx-auto px-5 lg:px-6 py-12">
        <h1 class="text-4xl font-bold">
            Licenses
        </h1>

        <div class="divide-y divide-gray-300">
            <div class="py-12">
                <h2 class="text-xl font-semibold">
                    Summary
                </h2>
                <p class="text-gray-500 text-sm">
                    Here’s an overview of what each license allows for to make it easy to pick what you need:
                </p>
                <table class="table-auto w-full mt-3 border-collapse border border-gray-300 text-gray-500 text-sm">
                    <thead>
                    <tr>
                        <th class="border border-gray-300 p-3"></th>
                        @foreach($licenses as $license)
                            <th class="border border-gray-300 p-3">
                                {{ $license->name }}
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border border-gray-300 p-3">
                            Number of end products
                        </td>
                        @foreach($licenses as $license)
                            <td class="border border-gray-300 p-3">
                                {{ $license->end_products }}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-3">
                            Use for personal or a client
                        </td>
                        @foreach($licenses as $license)
                            <td class="border border-gray-300 p-3">
                                @if($license->for_personal_or_client)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-3">
                            Use in a free end product
                            <em>(Can have multiple users)</em>
                        </td>
                        @foreach($licenses as $license)
                            <td class="border border-gray-300 p-3">
                                @if($license->for_multiple_user_product)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-3">
                            Use in an end product that is “sold”
                            <em>(Can have multiple paying users)</em>
                        </td>
                        @foreach($licenses as $license)
                            <td class="border border-gray-300 p-3">
                                @if($license->for_multiple_paying_user_product)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-3">
                            Use in derivative themes or “generators”
                        </td>
                        @foreach($licenses as $license)
                            <td class="border border-gray-300 p-3">
                                @if($license->for_theme_generators)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
            @foreach($licenses as $license)
                <div class="py-16 trix-content">
                    {!! $license->description !!}
                </div>
            @endforeach
            <div class="py-12 space-y-3">
                <h2 class="font-semibold">
                    Definitions:
                </h2>
                <ul class="list-disc pl-5 list-inside">
                    <li>
                        Theme is purchased digital work
                    </li>
                    <li>
                        End Product is a customized implementation of the Theme
                    </li>
                    <li>
                        End User is a user of the End Product
                    </li>
                    <li>
                        Client is a contracted employer of the license holder
                    </li>
                </ul>
            </div>
            <div class="py-12 space-y-3">
                <h2 class="font-semibold">
                    Need help picking your license?
                </h2>
                <p>
                    Just shoot us an email at <a href="mailto:{{ env('CONTACT_MAIL') }}"
                                                 class="text-blue-500">{{ env('CONTACT_MAIL') }}</a> and we’ll help you
                    decide which license makes sense for your needs!
                </p>
            </div>
            <div class="py-12 space-y-3">
                <h2 class="font-semibold">
                    Want to upgrade your license?
                </h2>
                <p>
                    There may be times when you need to upgrade your license from the original type you purchased and we
                    have a solution that ensures you can apply your original purchase cost to the new license purchase.
                    Please email <a href="mailto:{{ env('CONTACT_MAIL') }}"
                                    class="text-blue-500">{{ env('CONTACT_MAIL') }}</a> with the following information:
                </p>
                <ul class="list-disc pl-5 list-inside">
                    <li>
                        Original Order #:
                    </li>
                    <li>
                        [If you have purchased multiple themes] Which theme you’d like to upgrade:
                    </li>
                    <li>
                        Email address associated with the order:
                    </li>
                    <li>
                        Type of License to upgrade to: (Extended or Multisite)
                    </li>
                </ul>
                <p>
                    Once we receive the information above, we’ll generate a personalized coupon code that will take your
                    initial purchase price off of the upgraded license. You WILL be able to stack this coupon with any
                    other
                    all-site promotions that are currently active, which will be listed directly at
                    {{ env('APP_URL') }}
                    if there are any.
                    <br><br>
                    In the future we will have a way to do this directly from your dashboard, and we’ll update this
                    article
                    when that’s ready! In the meantime we’re happy to assist manually and you should expect an answer
                    within
                    24-48 business hours.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
