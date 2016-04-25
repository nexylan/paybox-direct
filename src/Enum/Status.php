<?php

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\BaseEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Status extends BaseEnum
{
    const REFUNDED = 'Remboursé';
    const CANCELED = 'Annulé';
    const AUTHORIZED = 'Autorisé';
    const CAPTURED = 'Capturé';
    const CREDIT = 'Crédit';
    const REFUSED = 'Refusé';
    const BALANCE_INQUIRY = 'Demande de solde (Carte cadeaux)';
    const SUPPORT_REJECTION = 'Rejet support';
}
