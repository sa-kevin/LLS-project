import { Link } from '@inertiajs/react';

export default function Pagination({ links }) {
  return (
    <div className="mt-6 flex justify-center">
      {links.map((link, key) => (
        <Link
          key={key}
          href={link.url}
          className={
            'inline-block py-2 px-3 rounded-lg text-gray-200 text-xs ' +
            (link.active ? 'bg-gray-950 ' : ' ') +
            (!link.url
              ? '!text-gray-500 cursor-not-allowed '
              : 'hover:bg-gray-950')
          }
          preserveState
        >
          <span dangerouslySetInnerHTML={{ __html: link.label }}></span>
        </Link>
      ))}
    </div>
  );
}
