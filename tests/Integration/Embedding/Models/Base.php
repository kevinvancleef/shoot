<?php
declare(strict_types=1);

namespace Shoot\Shoot\Tests\Integration\Embedding\Models;

use Shoot\Shoot\HasPresenterInterface;
use Shoot\Shoot\PresentationModel;
use Shoot\Shoot\Tests\Integration\Embedding\Presenters\BasePresenter;

final class Base extends PresentationModel implements HasPresenterInterface
{
    /** @var string */
    protected $title = '';

    /**
     * Returns the name by which to resolve the presenter through the DI container.
     *
     * @return string
     */
    public function getPresenterName(): string
    {
        return BasePresenter::class;
    }
}
