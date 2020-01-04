<form wire:submit.prevent>
    @csrf

    <div class="form-group row">
        <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('Comment') }}</label>

        <div class="col-md-6">
            <textarea name="comment" id="comment" cols="30" rows="10" wire:model="comment" class="form-control @error('comment') is-invalid @enderror"></textarea>

            @error('comment')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary" wire:click="submit">
                {{ __('Create') }}
            </button>
        </div>
    </div>
</form>
