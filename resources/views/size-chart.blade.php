@extends('base.base')

@section('content')
<style>
    :root {
        --primary: #ffffff;
        --secondary: #000000;
        --accent: #D4AF37;
        --accent-light: #F8F1D5;
        --accent-dark: #9E7C1F;
        --light-gray: #f9f9f9;
        --medium-gray: #e0e0e0;
        --text-primary: #000000;
        --text-secondary: #505050;
        --text-accent: #D4AF37;
        --transition: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Dark mode variable overrides */
    body.dark-mode {
        --primary: #121212;
        --secondary: #f5f5f5;
        --light-gray: #1e1e1e;
        --medium-gray: #333333;
        --text-primary: #f5f5f5;
        --text-secondary: #aaaaaa;
    }

    /* Main container */
    .size-chart-container {
        max-width: 1100px;
        margin: 40px auto 60px;
        padding: 0 40px;
        font-family: 'Montserrat', sans-serif;
        color: var(--text-primary);
        position: relative;
        z-index: 1;
    }
    
    /* Pattern Overlay */
    .pattern-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: 1;
    }
    
    /* Gold accents */
    .gold-accent {
        position: absolute;
        width: 30%;
        height: 30%;
        background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
        filter: blur(20px);
        border-radius: 50%;
        z-index: 0;
        pointer-events: none;
    }

    .gold-accent-1 {
        top: -10%;
        right: 5%;
        animation: float 20s infinite alternate;
    }

    .gold-accent-2 {
        bottom: 10%;
        left: 5%;
        animation: float 25s infinite alternate-reverse;
    }

    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(10px, 15px) rotate(3deg);
        }

        100% {
            transform: translate(-10px, 5px) rotate(-3deg);
        }
    }
    
    /* Page title styling - updated to match the store page */
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        letter-spacing: 4px;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--accent);
        text-align: center;
        margin: 50px 0 20px;
        text-transform: uppercase;
    }
    
    /* Subtitle styling */
    .page-subtitle {
        font-size: 1rem;
        color: var(--text-secondary);
        max-width: 480px;
        margin: 0 auto 50px;
        letter-spacing: 1px;
        text-align: center;
        font-weight: 300;
    }
    
    /* Back button - updated to match the store style */
    .back-button {
        display: inline-block;
        color: var(--primary);
        text-decoration: none;
        border: 1px solid var(--medium-gray);
        background-color: var(--secondary);
        padding: 8px 16px;
        border-radius: 0;
        font-size: 0.9rem;
        margin-bottom: 20px;
        transition: all 0.4s var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .back-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--accent);
        transition: all 0.4s;
        z-index: -1;
    }
    
    .back-button:hover {
        color: var(--secondary);
    }
    
    .back-button:hover::before {
        left: 0;
    }

    /* Size chart section */
    .size-chart {
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
    }
    
    .size-chart h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 500;
        margin: 40px 0 20px;
        color: var(--text-primary);
        position: relative;
        padding-bottom: 12px;
        letter-spacing: 1px;
    }
    
    .size-chart h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: var(--accent);
    }
    
    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: var(--primary);
        border: 1px solid var(--medium-gray);
    }
    
    table th,
    table td {
        text-align: center;
        padding: 16px;
        border-bottom: 1px solid var(--medium-gray);
        font-size: 0.95rem;
    }
    
    table th {
        font-weight: 500;
        color: var(--primary);
        background-color: var(--secondary);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    
    table tr:last-child td {
        border-bottom: none;
    }
    
    /* Category filter - updated to match store filter-bar */
    .filter-container {
        text-align: center;
        margin: 3rem 0;
        position: relative;
        z-index: 2;
        border-bottom: none;
    }
    
    .filter-button {
        border: none;
        padding: 0.6rem 1.5rem;
        margin: 0 0.5rem 0.5rem;
        border-radius: 0;
        background-color: transparent;
        cursor: pointer;
        transition: all 0.3s var(--transition);
        position: relative;
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .filter-button::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 1px;
        background-color: var(--accent);
        transition: all 0.3s var(--transition);
        transform: translateX(-50%);
    }
    
    .filter-button:hover::after,
    .filter-button.active::after {
        width: 70%;
    }
    
    .filter-button:hover,
    .filter-button.active {
        color: var(--accent);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .page-title {
            font-size: 3rem;
        }
    }
    
    @media (max-width: 768px) {
        .size-chart-container {
            padding: 20px;
            margin: 30px auto;
        }
        
        .page-title {
            font-size: 2.5rem;
        }
        
        table th,
        table td {
            padding: 10px;
            font-size: 0.85rem;
        }
        
        .size-chart h3 {
            font-size: 1.5rem;
        }
        
        .filter-button {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .page-title {
            font-size: 2rem;
        }
    }
</style>

<div class="pattern-overlay"></div>
<div class="gold-accent gold-accent-1"></div>
<div class="gold-accent gold-accent-2"></div>

<div class="size-chart-container">
    <a href="{{ route('store.show') }}" class="back-button">← Back To Store</a>
    
    <h1 class="page-title">Size Chart</h1>
    <p class="page-subtitle">Curated measurements for the discerning individual who appreciates timeless elegance.</p>
    
    
    <div class="size-chart" id="shirt-chart">
        <h3>Top Size Guide</h3>
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

    <div class="size-chart" id="pants-chart">
        <h3>Bottom Size Guide</h3>
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

    <div class="size-chart" id="dress-chart">
        <h3>Dress Size Guide</h3>
        <table>
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Bust (cm)</th>
                    <th>Waist (cm)</th>
                    <th>Hips (cm)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>XS</td><td>28.0</td><td>24.0</td><td>14.5</td></tr>
                <tr><td>S</td><td>30.0</td><td>26.0</td><td>15.0</td></tr>
                <tr><td>M</td><td>32.0</td><td>28.0</td><td>15.5</td></tr>
                <tr><td>L</td><td>34.0</td><td>30.0</td><td>16.0</td></tr>
                <tr><td>XL</td><td>36.0</td><td>32.0</td><td>16.5</td></tr>
                <tr><td>XXL</td><td>38.0</td><td>34.0</td><td>17.0</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterChart(category) {
        // Remove active class from all buttons
        const buttons = document.querySelectorAll('.filter-button');
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        
        // Add active class to clicked button
        event.target.classList.add('active');
        
        // Show/hide charts based on selection
        const shirtChart = document.getElementById('shirt-chart');
        const pantsChart = document.getElementById('pants-chart');
        const dressChart = document.getElementById('dress-chart');
        const accessoriesChart = document.getElementById('accessories-chart');
        
        if (category === 'all') {
            shirtChart.style.display = 'block';
            pantsChart.style.display = 'block';
            dressChart.style.display = 'block';
            accessoriesChart.style.display = 'block';
        } else if (category === 'shirt') {
            shirtChart.style.display = 'block';
            pantsChart.style.display = 'none';
            dressChart.style.display = 'none';
            accessoriesChart.style.display = 'none';
        } else if (category === 'pants') {
            shirtChart.style.display = 'none';
            pantsChart.style.display = 'block';
            dressChart.style.display = 'none';
            accessoriesChart.style.display = 'none';
        } else if (category === 'dress') {
            shirtChart.style.display = 'none';
            pantsChart.style.display = 'none';
            dressChart.style.display = 'block';
            accessoriesChart.style.display = 'none';
        } else if (category === 'accessories') {
            shirtChart.style.display = 'none';
            pantsChart.style.display = 'none';
            dressChart.style.display = 'none';
            accessoriesChart.style.display = 'block';
        }
    }
    
    // Initialize AOS animation library if it's loaded
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
</script>
@endsection