 <div class="modal fade" id="approveModal{{ $item->id }}" tabindex="-1" role="dialog"
     aria-labelledby="approveModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <form action="{{ route('items.approve') }}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $item->id }}">
             <input type="hidden" name="item_id" value="{{ $item->itemId }}">
             <input type="hidden" name="specification_id" value="{{ $item->specificationId }}">
             <input type="hidden" name="max_quantity" value="{{ $item->totalQuantity }}">

             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Approve Quantity</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span>&times;</span>
                     </button>
                 </div>

                 <div class="modal-body">
                     <div class="form-group">
                         <label>Approved Quantity</label>
                         <input type="number" name="approved_quantity" class="form-control" min="1" required
                             value="{{ old('id') == $item->id ? old('approved_quantity') : '' }}">
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="submit" class="btn btn-success">Approve</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                 </div>
             </div>
         </form>
     </div>
 </div>
