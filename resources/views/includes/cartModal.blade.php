@if(isset($cart))
    {{-- Cart Modal --}}
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLongTitle">تایید سبد خرید</h5>
                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(count($cart)>0)
                        <form action="{{route('factor.store')}}" method="post">
                            @csrf
                            <p>آیا از خرید اطمینان دارید؟</p>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>عنوان محصول</th>
                                    <th>تعداد</th>
                                    <th>قیمت</th>
                                </tr>
                                @php $sum = 0 @endphp
                                @foreach($cart as $item)
                                    <tr>
                                        <td>{{$item->product->title}}</td>
                                        <td>{{$item->count}}</td>
                                        <td>{{\Illuminate\Support\Str::of($item->product->price)->reverse()->substrReplace(',',3,0)->reverse()}}&nbsp;تومان</td>
                                    </tr>
                                    @php $sum += $item->product->price*$item->count @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3">مبلغ پرداختی:&nbsp;@php echo number_format($sum); @endphp&nbsp;تومان
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">موجودی کیف پول شما:&nbsp;{{ number_format(\Illuminate\Support\Facades\Auth::user()->wallet) }}&nbsp;تومان
                                    </td>
                                </tr>
                            </table>

                            <input type="submit" class="btn btn-primary" name="sumbit" value="پرداخت">
                            <input type="hidden" name="price" value="@php echo $sum; @endphp">
                        </form>
                    @else
                        <p>شما محصولی در سبد خرید خود ندارید!</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
    {{-- Cart Modal --}}
@endif