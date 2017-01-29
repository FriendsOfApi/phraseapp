<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\PhraseApp\Exception\Domain;

use FAPI\PhraseApp\Exception\DomainException;

final class UnprocessableEntityException extends \RuntimeException implements DomainException
{
}
