@extends('base.base')

@section('content')
<style>
    .size-chart-container {
        max-width: 1100px;
        margin: 60px auto;
        padding: 40px;
        background-color: #fafafa;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Cormorant', serif;
        color: #222;
    }

    .dark .size-chart-container {
        background-color: #121212;
        color: #f0f0f0;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.05);
    }

    .size-chart-container h2 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 40px;
    }

    .size-chart h3 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 40px 0 20px;
        color: inherit;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        background-color: white;
        color: #222;
    }

    .dark table {
        background-color: #1e1e1e;
        color: #eee;
        box-shadow: 0 3px 10px rgba(255, 255, 255, 0.05);
    }

    table thead {
        background-color: #f4f4f4;
    }

    .dark table thead {
        background-color: #2a2a2a;
    }

    table th,
    table td {
        text-align: center;
        padding: 16px;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }

    .dark table th,
    .dark table td {
        border-bottom: 1px solid #444;
    }

    table th {
        font-weight: 600;
        color: #333;
    }

    .dark table th {
        color: #ccc;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    .back-button {
        display: inline-block;
        color: #000;
        background-color: #f1f1f1;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .dark .back-button {
        color: #fff;
        background-color: #2a2a2a;
    }

    .back-button:hover {
        background-color: #e0e0e0;
    }

    .dark .back-button:hover {
        background-color: #3a3a3a;
    }

    @media (max-width: 768px) {
        .size-chart-container {
            padding: 20px;
        }

        table th,
        table td {
            padding: 10px;
            font-size: 14px;
        }

        .size-chart h3 {
            font-size: 1.4rem;
        }

        .size-chart-container h2 {
            font-size: 2rem;
        }
    }
</style>


<div class="size-chart-container">
    <a href="{{ route('store.show') }}" class="back-button">← Back to Store</a>
    <h2>Size Chart</h2>
    <div class="size-chart">
        <h3>Shirt Size Guide</h3>
        <table>
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Chest (cm)</th>
                    <th>Length (cm)</th>
                    <th>Sleeve (cm)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>XS</td><td>86</td><td>65</td><td>18</td></tr>
                <tr><td>S</td><td>92</td><td>68</td><td>20</td></tr>
                <tr><td>M</td><td>98</td><td>71</td><td>21</td></tr>
                <tr><td>L</td><td>104</td><td>74</td><td>22</td></tr>
                <tr><td>XL</td><td>110</td><td>77</td><td>23</td></tr>
                <tr><td>XXL</td><td>116</td><td>80</td><td>24</td></tr>
            </tbody>
        </table>
    </div>

    <div class="size-chart">
        <h3>Pants Size Guide</h3>
        <table>
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Waist (cm)</th>
                    <th>Hip (cm)</th>
                    <th>Length (cm)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>XS</td><td>66</td><td>88</td><td>92</td></tr>
                <tr><td>S</td><td>72</td><td>94</td><td>94</td></tr>
                <tr><td>M</td><td>78</td><td>100</td><td>96</td></tr>
                <tr><td>L</td><td>84</td><td>106</td><td>98</td></tr>
                <tr><td>XL</td><td>90</td><td>112</td><td>100</td></tr>
                <tr><td>XXL</td><td>96</td><td>118</td><td>102</td></tr>
            </tbody>
        </table>
    </div>

    <div class="size-chart">
    <h3>Dress Size Guide</h3>
    <table>
        <thead>
            <tr>
                <th>Size</th>
                <th>Bust (cm)</th>
                <th>Waist (cm)</th>
                <th>Hip (cm)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>XS</td><td>80</td><td>62</td><td>86</td></tr>
            <tr><td>S</td><td>86</td><td>68</td><td>92</td></tr>
            <tr><td>M</td><td>92</td><td>74</td><td>98</td></tr>
            <tr><td>L</td><td>98</td><td>80</td><td>104</td></tr>
            <tr><td>XL</td><td>104</td><td>86</td><td>110</td></tr>
            <tr><td>XXL</td><td>110</td><td>92</td><td>116</td></tr>
        </tbody>
    </table>
    </div>
</div>
@endsection
