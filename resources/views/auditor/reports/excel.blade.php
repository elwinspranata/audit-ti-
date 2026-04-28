<table>
    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000;">JOINT RISK ASSESSMENT REPORT</td>
    </tr>
    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000;">{{ $report->report_title ?? 'Audit Report' }}</td>
    </tr>
    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; text-align: center; border: 1px solid #000000;">Report Date: {{ $report->finalized_at ? $report->finalized_at->format('d F Y') : now()->format('d F Y') }}</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">1. REPORT INFORMATION</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Company Name</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->company_name }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Sign off Authority</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->sign_off_authority }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Audit Director</td>
        <td style="border: 1px solid #000000;">{{ $report->audit_director }}</td>
        <td style="font-weight: bold; border: 1px solid #000000;">Manager</td>
        <td colspan="2" style="border: 1px solid #000000;">{{ $report->audit_manager }}</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">2. OVERALL ASSESSMENT DASHBOARD</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Maturity Rating (Actual)</td>
        <td colspan="2" style="border: 1px solid #000000; text-align: center; color: #0000ff; font-weight: bold;">{{ $report->maturity_rating_actual }} ({{ $report->capability_label }})</td>
        <td style="font-weight: bold; border: 1px solid #000000;">Target Rating</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $report->maturity_rating_target }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000; background-color: #fee2e2;">Priority A (Major)</td>
        <td colspan="2" style="border: 1px solid #000000; text-align: center; color: #ff0000; font-weight: bold;">{{ $pCounts['A'] ?? 0 }}</td>
        <td style="font-weight: bold; border: 1px solid #000000; background-color: #ffedd5;">Priority B (Moderate)</td>
        <td style="border: 1px solid #000000; text-align: center; color: #f97316; font-weight: bold;">{{ $pCounts['B'] ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000; background-color: #dcfce7;">Priority C (Minor)</td>
        <td colspan="2" style="border: 1px solid #000000; text-align: center; color: #16a34a; font-weight: bold;">{{ $pCounts['C'] ?? 0 }}</td>
        <td style="font-weight: bold; border: 1px solid #000000; background-color: #f3f4f6;">Overall Score</td>
        <td style="border: 1px solid #000000; text-align: center; color: #0000ff; font-weight: bold;">{{ $report->overall_score ?? 0 }} / 100</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">3. EXECUTIVE SUMMARY</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Conclusion</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->conclusion }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Background</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->background }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Audit Scope</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->scope }}</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">7. REPORTABLE ISSUES & CORRECTIVE ACTIONS</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #000000;">Issue Observation</td>
        <td style="background-color: #f3f4f6; font-weight: bold; text-align: center; border: 1px solid #000000;">Priority</td>
        <td colspan="2" style="background-color: #f3f4f6; font-weight: bold; border: 1px solid #000000;">Corrective Action & Officer</td>
    </tr>
    @foreach($report->reportable_issues ?? [] as $issue)
    <tr>
        <td colspan="2" style="border: 1px solid #000000;">{{ $issue['title'] ?? 'Finding' }} - {{ $issue['condition'] ?? '' }}</td>
        <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">{{ $issue['priority'] ?? 'C' }}</td>
        <td colspan="2" style="border: 1px solid #000000;">Target: {{ $issue['due_date'] ?? '-' }} | Officer: {{ $issue['response_from'] ?? '-' }} - {{ $issue['corrective_action'] ?? '-' }}</td>
    </tr>
    @endforeach
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">8. RESPONSIBLE OFFICER RESPONSE</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Officer Name / Title</td>
        <td colspan="4" style="border: 1px solid #000000;">{{ $report->officer_name }} ({{ $report->officer_title }})</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">Official Response</td>
        <td colspan="4" style="border: 1px solid #000000; font-style: italic;">{{ $report->officer_response }}</td>
    </tr>
    <tr><td colspan="5"></td></tr>

    <tr>
        <td colspan="5" style="background-color: #333333; color: #ffffff; font-weight: bold; border: 1px solid #000000;">COBIT MATURITY RATING DEFINITIONS</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">0. Incomplete</td>
        <td colspan="4" style="border: 1px solid #000000;">The process is not implemented or fails to achieve its purpose.</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">1. Performed</td>
        <td colspan="4" style="border: 1px solid #000000;">The implemented process achieves its process purpose.</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">2. Managed</td>
        <td colspan="4" style="border: 1px solid #000000;">Process is planned, monitored and adjusted; work products are established.</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">3. Established</td>
        <td colspan="4" style="border: 1px solid #000000;">Process is implemented using a defined process capable of achieving outcomes.</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">4. Predictable</td>
        <td colspan="4" style="border: 1px solid #000000;">Process operates within defined limits to achieve its outcomes.</td>
    </tr>
    <tr>
        <td style="font-weight: bold; border: 1px solid #000000;">5. Optimizing</td>
        <td colspan="4" style="border: 1px solid #000000;">Process is continuously improved to meet business goals.</td>
    </tr>
</table>
