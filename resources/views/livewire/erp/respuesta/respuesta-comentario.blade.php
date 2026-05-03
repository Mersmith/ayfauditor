<div style="margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px;">
    <h3>💬 Comentarios y Observaciones Internas</h3>

    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; max-height: 400px; overflow-y: auto;">
        @forelse($comentarios as $coment)
            <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <strong>{{ $coment->user->name }}</strong>
                    <small style="color: gray;">{{ $coment->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <p style="margin: 0; font-size: 0.95rem;">{{ $coment->mensaje }}</p>
            </div>
        @empty
            <p style="color: gray; text-align: center;">No hay comentarios registrados para esta respuesta.</p>
        @endforelse
    </div>

    <form wire:submit.prevent="saveComment">
        <div>
            <label>Nuevo Comentario / Observación:</label>
            <textarea wire:model="mensaje" style="width: 100%; height: 80px;" placeholder="Escriba una observación interna o nota para otros auditores..."></textarea>
            @error('mensaje') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        @if (session()->has('message'))
            <div style="color: green; margin-top: 10px;">
                {{ session('message') }}
            </div>
        @endif

        <div style="margin-top: 10px; text-align: right;">
            <button type="submit" style="background-color: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                Enviar Comentario
            </button>
        </div>
    </form>
</div>
