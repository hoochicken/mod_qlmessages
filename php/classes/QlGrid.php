<?php

class QlGrid
{
    private array $columns = [];
    private array $data = [];
    private string $tableStyle;
    private string $tableClass;
    private string $tableId;

    const TABLE_CLASS_DEFAULT = 'table table-striped table-hover';
    const TABLE_ID_DEFAULT = 'qlgrid';

    const TABLE = 'table';
    const TABLE_HEAD = 'thead';
    const TABLE_BODY = 'tbody';
    const TABLE_ROW = 'tr';
    const TABLE_TH = 'th';
    const TABLE_TD = 'td';
    const TAG_OPEN = '<';
    const TAG_CLOSE = '>';

    public function __construct(array $data = [], ?array $columns = [])
    {
        $this->setData($data);
        $this->setColumns($columns);
    }

    public function getHtmlTable(): string
    {
        if (0 >= count($this->getData())) return '';

        $attributes = ['id' => $this->getTableId(), 'class' => $this->getTableClass(), 'style' => $this->getTableClass(), ];
        $html[] = $this->getHtmlTag(self::TABLE, false, $attributes);
        $html[] = $this->getHtmlTableHead($this->getColumns());
        $html[] = $this->getHtmlTableBody();
        $html[] = $this->getHtmlTag(self::TABLE, true);
        return $this->arrayToString($html);
    }

    public function getHtmlTableHead($columns): string
    {
        $html = [];
        $html[] = $this->getHtmlTag(self::TABLE_HEAD);
        $html[] = $this->getHtmlTableRow($columns, self::TABLE_TH);
        $html[] = $this->getHtmlTag(self::TABLE_HEAD, true);
        return $this->arrayToString($html);
    }

    private function arrayToString(array $html, $separator = "\n")
    {
        return implode($separator, $html);
    }

    public function getHtmlTableBody(): string
    {
        $html = [];
        $html[] = $this->getHtmlTag(self::TABLE_BODY);
        foreach($this->getData() as $data) {
            $html[] = $this->getHtmlTableRow((array)$data);
        }
        $html[] = $this->getHtmlTag(self::TABLE_BODY, true);
        return $this->arrayToString($html);
    }

    public function getHtmlTableRow(array $row, $cellTag = self::TABLE_TD): string
    {
        $html = [];
        $html[] = $this->getHtmlTag(self::TABLE_ROW);
        foreach ($this->getColumnsRaw() as $column) {
            $cellContent = $row[$column] ?? '';
            $htmlCell = $this->getHtmlTableCell($cellContent, $cellTag);
            $html[] = $htmlCell;
        }
        $html[] = $this->getHtmlTag(self::TABLE_ROW, true);
        return $this->arrayToString($html, '');
    }

    public function getHtmlTableCell(string $value, string $tag = self::TABLE_TD): string
    {
        $html = $this->getHtmlTag($tag);
        $html .= $value;
        $html .= $this->getHtmlTag($tag, true);
        return $html;
    }

    public function getHtmlTag(string $value, bool $end = false, array $attributes = []): string
    {
        $attributes = array_filter($attributes);
        if (0 < count($attributes)) array_walk($attributes, function(&$item, $key) {
            $item = sprintf('%s="%s"', $key, $item);
        });
        if ($end) $attributes = [];
        $attributes = ' ' . $this->arrayToString($attributes, '');
        return self::TAG_OPEN . ($end ? '/' : '') . $value . $attributes . self::TAG_CLOSE;
    }

    public function setTableStyle(string $value = '')
    {
        $this->tableStyle = $value;
    }

    public function setTableClass(string $value = self::TABLE_CLASS_DEFAULT)
    {
        $this->tableClass = $value;
    }

    public function setTableId(string $value = self::TABLE_ID_DEFAULT)
    {
        $this->tableId = $value;
    }

    public function getTableStyle(): string
    {
        return $this->tableStyle ?? '';
    }

    public function getTableClass(): string
    {
        return $this->tableClass ?? self::TABLE_CLASS_DEFAULT;
    }

    public function getTableId(): string
    {
        return $this->tableId ?? self::TABLE_ID_DEFAULT;
    }

    public function setColumns(?array $value)
    {
        if (!is_null($value) && 0 < count($value)) {
            $this->columns = $value;
            return;
        }
        $columns = isset($this->getData()[0]) ? array_keys((array)$this->getData()[0]) : [];
        $this->columns = self::enrichColumns($columns);
    }

    static public function enrichColumns(?array $value): array
    {
        $columns = array_combine($value, $value);
        array_walk($columns, function(&$item) { $item = ucwords($item); });
        return $columns;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getColumnsRaw(): array
    {
        return array_keys($this->columns);
    }

    public function setData($value)
    {
        $this->data = $value;
    }

    public function getData(?string $column = null)
    {
        return is_null($column) || !isset($this->data[$column]) ? $this->data : $this->data[$column];
    }
}