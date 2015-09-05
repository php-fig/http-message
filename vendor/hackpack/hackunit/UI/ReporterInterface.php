<?hh //strict
namespace HackPack\HackUnit\UI;

use HackPack\HackUnit\Core\TestResult;

interface ReporterInterface
{
    public function getReport(TestResult $result): string;

    public function printReport(TestResult $result): void;
}
