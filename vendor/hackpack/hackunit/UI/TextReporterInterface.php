<?hh //strict
namespace HackPack\HackUnit\UI;

use HackPack\HackUnit\Core\TestResult;

interface TextReporterInterface extends ReporterInterface
{
    /**
     * Method for printing live feedback in a text based
     * user interface
     */
    public function printFeedback(string $feedback): void;
}
