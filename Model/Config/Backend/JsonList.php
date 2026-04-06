<?php

declare(strict_types=1);

namespace Sd\RequestLogger\Model\Config\Backend;

use Magento\Framework\App\Config\Value;
use Magento\Framework\Exception\LocalizedException;

class JsonList extends Value
{
    /**
     * @throws LocalizedException
     */
    public function beforeSave(): self
    {
        $value = trim((string) $this->getValue());

        if ($value === '') {
            $this->setValue('[]');
            return parent::beforeSave();
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw new LocalizedException(
                __('"%1" must be a valid JSON array (e.g. ["/V1/orders", "/V1/customers/*"]).', $this->getFieldConfig()['label'])
            );
        }

        foreach ($decoded as $item) {
            if (!is_string($item)) {
                throw new LocalizedException(
                    __('"%1" must be a JSON array of strings.', $this->getFieldConfig()['label'])
                );
            }
        }

        $this->setValue(json_encode(array_values($decoded), JSON_UNESCAPED_SLASHES));

        return parent::beforeSave();
    }
}
