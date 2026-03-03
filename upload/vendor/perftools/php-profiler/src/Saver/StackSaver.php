<?php

namespace Xhgui\Profiler\Saver;

use Exception;

/**
 * Save to stack of savers.
 *
 * Supports saving to all savers, or to first successful one.
 */
final class StackSaver implements SaverInterface
{
    /** @var array */
    private $savers;
    /** @var bool */
    private $saveAll;

    public function __construct(array $savers, $saveAll = false)
    {
        $this->savers = $this->validateSavers($savers);
        $this->saveAll = (bool)$saveAll;
    }

    public function isSupported()
    {
        return count($this->savers) > 0;
    }

    public function save(array $data)
    {
        $result = false;
        foreach ($this->savers as $saver) {
            try {
                if (!$saver->save($data)) {
                    continue;
                }
                $result = true;
            } catch (Exception $e) {
                continue;
            }

            // if not save all, then break on first successful save
            if (!$this->saveAll) {
                break;
            }
        }

        return $result;
    }

    private function validateSavers(array $savers)
    {
        $result = array();
        foreach ($savers as $saver) {
            try {
                if (!$saver->isSupported()) {
                    continue;
                }
            } catch (Exception $e) {
                continue;
            }
            $result[] = $saver;
        }

        return $result;
    }
}
