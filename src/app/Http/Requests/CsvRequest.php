<?php

namespace App\Http\Requests;

use App\Models\Area;
use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use SplFileObject;

class CsvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'csv_file' => ['required', 'file', 'mimetypes:text/plain,text/csv', 'mimes:csv,txt'],
            'csv_array' => ['required', 'array'],
            'csv_array.*.name' => ['required', 'string', 'max:50'],
            'csv_array.*.email' => ['required', 'string', 'unique:users,email', 'distinct:ignore_case'],
            'csv_array.*.password' => ['required', 'string', 'min:8', 'max:191'],
            'csv_array.*.area_id' => ['required', 'integer', 'exists:areas,id'],
            'csv_array.*.genre_id' => ['required', 'integer', 'exists:genres,id'],
            'csv_array.*.sentence' => ['required', 'string', 'max:400'],
            'csv_array.*.image_url' => ['required', 'url', 'regex:/.(png|jpg|jpeg)$/'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->validate(
            ['csv_file' => ['required', 'file', 'mimetypes:text/plain,text/csv', 'mimes:csv,txt']],
            [
                'csv_file.required' => 'CSVファイルを指定してください',
                'csv_file.mimetypes' => 'テキストファイルを指定してください',
                'csv_file.mimes' => '拡張子が[.csv]のファイルを指定してください'
            ]
        );

        $file_path = $this->file('csv_file')->path();

        $fileData = file_get_contents($file_path);

        // 改行を統一
        $fileData = preg_replace("/\r\n|\r/", "\n", $fileData);

        // SJISからUTF-8へ変換
        $encode = mb_detect_encoding($fileData, ['SJIS-win', 'UTF-8']);
        if ($encode == 'SJIS-win') {
            $fileData = mb_convert_encoding($fileData, 'UTF-8', 'SJIS-win');
        }

        // 一時ファイル作成
        $tmpName = tempnam(sys_get_temp_dir(), "csv");
        file_put_contents($tmpName, $fileData);

        $file = new SplFileObject($tmpName);
        $file->setFlags(
            SplFileObject::READ_CSV |
                SplFileObject::READ_AHEAD |
                SplFileObject::SKIP_EMPTY |
                SplFileObject::DROP_NEW_LINE
        );
        // 一時ファイル削除
        unlink($tmpName);

        $csv_array = [];
        foreach ($file as $index => $line) {
            // ヘッダーを取得
            if (empty($header)) {
                $header = $line;
                continue;
            }
            $csv_array[$index]['name'] = $line[0] ?? null;
            $csv_array[$index]['email'] = $line[1] ?? null;
            $csv_array[$index]['password'] = $line[2] ?? null;
            $csv_array[$index]['area_id'] = isset($line[3]) ? Area::where('name', $line[3])->first()->id ?? $line[3] : null;
            $csv_array[$index]['genre_id'] = isset($line[4]) ? Genre::where('name', $line[4])->first()->id ?? $line[4] : null;
            $csv_array[$index]['sentence'] = $line[5] ?? null;
            $csv_array[$index]['image_url'] = $line[6] ?? null;
        }
        $this->merge([
            'csv_array' => $csv_array,     //requestに項目追加
        ]);
    }

    public function messages()
    {
        $messages = [
            'csv_file.required' => 'CSVファイルを選択してください',
            'csv_array.required' => 'データが空です',
        ];
        foreach ($this->csv_array as $key => $value) {
            $index = $key + 1;
            $messages["csv_array.{$key}.name.required"] = "{$index}行目[name] - 入力必須です";
            $messages["csv_array.{$key}.name.string"] = "{$index}行目[name] - 文字列を使用してください - 入力値:{$value['name']}";
            $messages["csv_array.{$key}.name.max"] = "{$index}行目[name] - 50字以内で設定してください - 入力値:" . strlen($value['name']) . '字';
            $messages["csv_array.{$key}.password.required"] = "{$index}行目[password] - 入力必須です";
            $messages["csv_array.{$key}.password.min"] = "{$index}行目[password] - 8字以上で設定してください";
            $messages["csv_array.{$key}.email.required"] = "{$index}行目[email] - 入力必須です";
            $messages["csv_array.{$key}.email.unique"] = "{$index}行目[email] - 既に使用されています - 入力値:{$value['email']}";
            $messages["csv_array.{$key}.email.distinct"] = "{$index}行目[email] - 重複しています - 入力値:{$value['email']}";
            $messages["csv_array.{$key}.area_id.required"] = "{$index}行目[area] - 入力必須です";
            $messages["csv_array.{$key}.area_id.integer"] = "{$index}行目[area] - [東京都|大阪府|福岡県]のいずれかを設定してください - 入力値:{$value['area_id']}";
            $messages["csv_array.{$key}.genre_id.required"] = "{$index}行目[genre] - 入力必須です";
            $messages["csv_array.{$key}.genre_id.integer"] = "{$index}行目[genre] - [寿司|焼肉|イタリアン|居酒屋|ラーメン]のいずれかを設定してください - 入力値:{$value['genre_id']}";
            $messages["csv_array.{$key}.sentence.required"] = "{$index}行目[sentence] - 入力必須です";
            $messages["csv_array.{$key}.sentence.max"] = "{$index}行目[sentence] - 400字以内で設定してください - 入力:" . strlen($value['sentence']) . '字';
            $messages["csv_array.{$key}.image_url.required"] = "{$index}行目[image_url] - 入力必須です";
            $messages["csv_array.{$key}.image_url.url"] = "{$index}行目[image_url] - URLが無効です";
            $messages["csv_array.{$key}.image_url.regex"] = "{$index}行目[image_url] - [.png|.jpg|.jpeg]の拡張子のURLを設定して下さい - 入力値:{$value['image_url']}";
        }
        return $messages;
    }
}
