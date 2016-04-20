<?php

namespace Nexy\PayboxDirect\Variable;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxVariableStatus
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
