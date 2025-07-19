<x-pdf-layout>
    @php
        $prependedString = str_repeat('0', 4 - strlen($student->id)) . $student->id;

        function image($path)
        {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <div class="text-center">
        @if ($student->level > 0)
            <h1>2025/2026 Year 3 & Year 4 Applicant Form</h1>
        @else
            <h1>2025/2026 Entrance Exam Applicant Form</h1>
        @endif
    </div>

    <div>
        <img
         style="margin-bottom: 10px; border-radius: 8px"
         src="{{ image(asset($student->passport)) }}" width="90"
         height="90"
         alt="Passport photo"
        />
      <p>Application Number: <strong>COLTECH25{{ $prependedString }}</strong></p>
    </div>

    <h4>Personal Information</h4>
    <table>
        <tr>
            <td colspan="2">Bank Reference: <strong>{{ $student->bankref }}</strong></td>
        </tr>
        <tr>
            <td>Name: <strong>{{ $student->name }}</strong></td>
            <td>Email: <strong>{{ $student->email }}</strong></td>
        </tr>
        <tr>
            <td>Gender: <strong>{{ $student->gender }}</strong></td>
            <td>NIC: <strong>{{ $student->idc_number }}</strong></td>
        </tr>
        <tr>
            <td>Nationality: <strong>{{ $student->country }}</strong></td>
            <td>Tel: <strong>{{ $student->telephone }}</strong></td>
        </tr>
    </table>


    <h4>Degree information</h4>
    <table>
        <tr>
            <td>1<sup>st</sup> Choice:</td>
            <td>
                <strong>
                    {{ \App\Models\DepartmentOption::where('id', $student->option1)->first()->name ?? '' }}
                </strong>
            </td>
        </tr>
        <tr>
            <td>2<sup>nd</sup> Choice: </td>
            <td>
                <strong>
                    {{ \App\Models\DepartmentOption::where('id', $student->option2)->first()->name ?? '' }}
                </strong>
            </td>
        </tr>
        <tr>
            <td>3<sup>rd</sup> Choice: </td>
            <td>
                <strong>
                    {{ \App\Models\DepartmentOption::where('id', $student->option3)->first()->name ?? '' }}
                </strong>
            </td>
        </tr>
    </table>

    {{-- For first year students --}}
    @if ($student->level == 0)
        <h4>Examination information</h4>
        <table>
            <tr>
                <td>Examination Centre</td>
                <td>
                    <strong>
                        {{ $student->examCenter->name }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td>Examination Language</td>
                <td>
                    <strong>
                        {{ $student->primary_language == 'en' ? 'English' : 'French' }}
                    </strong>
                </td>
            </tr>
        </table>
    @endif

    @if (count($qualifications) > 0)
        <h4>Qualifications</h4>
        <table>
            @foreach ($qualifications as $qualification)
                <tr>
                    <td>Type: <strong>{{ $qualification->qualificationType->name }}</strong></td>
                    <td>
                        Grade/Points: <strong>{{ $qualification->points }}</strong>
                    </td>
                    <td>
                        Year: <strong>{{ $qualification->year }}</strong>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <h3>BRING THE FOLLOWING TO YOUR EXAMINATION CENTRE</h3>
    <hr>
    <ol>
        <li>A registration form to be completed online at the website of the <a href="https://coltech.uniba.cm">College
                of
                Technology</a>
        </li>
        <li> A certified true copy of birth certificate dated not more than six (6) months</li>
        @if ($student->level == 0)
            <li>A certified true copy of GCE A/L or Baccalaureate or equivalent diploma dated not more than six (6)
                months
            </li>
            <li>A certified true copy of GCE O/L or Probatoire or equivalent diploma dated not more than six (6) months
            </li>
        @else
            <li>A certified true copy of HND or DEGREE dated not more that six (6) months:</li>
        @endif
        <li>A receipt of payment of the sum of twenty thousand (20,000) FCFA being a non-refundable registration fee to
            be paid into COLTECH’s NFC Bank Account No. 10025 00030 16401043842 53, <strong>No other form of payment will
                be accepted</strong>
        </li>
        <li>One A4 size. Self-addressed stamped envelope</li>
        <li>Four passport-size photographs</li>
    </ol>
</x-pdf-layout>
