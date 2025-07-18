import { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg
            {...props}
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
        >
            <path d="M23.498 6.186a2.972 2.972 0 0 0-2.092-2.1C19.642 3.5 12 3.5 12 3.5s-7.642 0-9.406.586a2.972 2.972 0 0 0-2.092 2.1C0 7.958 0 12 0 12s0 4.042.502 5.814a2.972 2.972 0 0 0 2.092 2.1C4.358 20.5 12 20.5 12 20.5s7.642 0 9.406-.586a2.972 2.972 0 0 0 2.092-2.1C24 16.042 24 12 24 12s0-4.042-.502-5.814ZM9.75 15.5v-7l6.5 3.5-6.5 3.5Z" />
        </svg>
    );
}
