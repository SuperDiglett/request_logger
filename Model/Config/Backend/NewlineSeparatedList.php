<?php

declare(strict_types=1);

namespace Sd\RequestLogger\Model\Config\Backend;

use Magento\Framework\App\Config\Value;
use Magento\Framework\Exception\LocalizedException;

class NewlineSeparatedList extends Value
{
    /**
     * @throws LocalizedException
     */
    public function beforeSave(): self
    {
        $value = (string) $this->getValue();

        if ($value !== '' && str_contains($value, ',')) {
            throw new LocalizedException(
                __('"%1" must contain one entry per line, not comma-separated values.', $this->getFieldConfig()['label'])
            );
        }

        $lines = array_filter(
            array_map('trim', explode("\n", $value))
        );

        $this->setValue(implode("\n", $lines));

        return parent::beforeSave();
    }
}
