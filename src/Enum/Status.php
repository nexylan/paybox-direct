<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\AbstractEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Status extends AbstractEnum
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
