<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'applicant_to_id',
        'responsible_id',
        'is_deleted',
        'delete_by_user_id',
        'resolution_area_id',
        'type_id',
        'status_id',
        'client_description',
        'description',
        'created_at',
        'updated_at',
        'evaluation_at',
        'start_at',
        'end_at',
        'closed_at',
    ];
    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo User.
     * Establece que el modelo actual (probablemente `Order`) está relacionado con el modelo `User`
     * a través de la columna `client_id`. Cada orden tiene un único cliente asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo User.
     * Establece que el modelo actual está relacionado con el modelo `User` a través de la columna `applicant_to_id`.
     * Este método define que una orden está asociada a un solicitante (un usuario que aplica para algo).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicantTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_to_id');
    }

    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo User.
     * Establece que el modelo actual está relacionado con el modelo `User` a través de la columna `responsible_id`.
     * Esto indica que una orden tiene un responsable asignado (un usuario encargado de la orden).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo Resolution_Area.
     * Establece que el modelo actual está relacionado con el modelo `Resolution_Area`.
     * Cada orden está asociada a una área de resolución que probablemente sea responsable de la toma de decisiones sobre esa orden.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resolutionArea(): BelongsTo
    {
        return $this->belongsTo(Resolution_Area::class);
    }

    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo Type.
     * Establece que el modelo actual está relacionado con el modelo `Type`.
     * Esto asocia la orden con un tipo específico (por ejemplo, un tipo de solicitud o pedido).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Relación de "pertenece a" (BelongsTo) con el modelo Status.
     * Establece que el modelo actual está relacionado con el modelo `Status`.
     * Esto asigna un estado a la orden (por ejemplo, "pendiente", "en progreso", "finalizada").
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Relación de "tiene muchos" (HasMany) con el modelo File.
     * Establece que el modelo actual tiene una relación de tipo "uno a muchos" con el modelo `File`.
     * Esto significa que una orden puede tener múltiples archivos asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Mutador para el atributo 'start_at'.
     *
     * Este mutador establece el valor del campo 'start_at'. Si el valor recibido
     * coincide con el texto configurado en 'custom.text_for_start_at_edit' (indicado
     * para representar el estado "No iniciado"), el valor será almacenado como null.
     * Si el valor recibido es diferente, se asigna tal cual.
     *
     * @param mixed $value El valor del atributo 'start_at' que se va a establecer.
     * @return void
     */
    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = ($value == config('custom.text_for_start_at_edit')) ? null : $value;
    }

    /**
     * Mutador para el atributo 'end_at'.
     *
     * Este mutador establece el valor del campo 'end_at'. Si el valor recibido
     * coincide con el texto configurado en 'custom.text_for_end_at_edit' (indicado
     * para representar el estado "No finalizado"), el valor será almacenado como null.
     * Si el valor recibido es diferente, se asigna tal cual.
     *
     * @param mixed $value El valor del atributo 'end_at' que se va a establecer.
     * @return void
     */
    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = ($value == config('custom.text_for_end_at_edit')) ? null : $value;
    }

    /**
     * Establece el valor del campo `applicant_to_id` en función de la relación con `responsible_id`.
     * Si `responsible_id` no es null y el valor de `applicant_to_id` es null, asigna el valor de `responsible_id` a `applicant_to_id`.
     * Si `applicant_to_id` ya tiene un valor, se asigna el valor proporcionado.
     *
     * @param mixed $value El valor a establecer en `applicant_to_id`.
     * @return void
     */
    public function setApplicantToIdAttribute($value)
    {
        $this->attributes['applicant_to_id'] = $value ?? $this->responsible_id;
    }
    /**
     * Verificar si el usuario puede aceptar la orden.
     */
    public function acceptOrder()
    {
        return $this->status_id == 1;
    }

    /**
     * Verificar si el usuario puede finalizar la orden.
     */
    public function finishOrder()
    {
        $user = User::find(Auth::id());
        return $this->status_id <= 2 &&
            ($this->applicant_to_id == Auth::id() ||
                (!$user->isClient() && Gate::allows('isGroupMember', [$user, $this->applicantTo])));
    }
    /**
     * Obtener el ancho del botón de retorno.
     */
    public function getButtonWidthClass()
    {   
        // Verificar si la orden ya ha sido finalizada o no es el mismo usuario para poder poner el botón de retorno completo
        if ($this->finishOrder()) {
            return 'w-25';
        }
        return 'w-full';
    }


}
